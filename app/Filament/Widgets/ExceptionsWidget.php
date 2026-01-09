<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Assignment;
use App\Models\Person;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Collection;

class ExceptionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Exceptions';

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('type')->label('Issue'),
            TextColumn::make('count')->label('Count'),
            TextColumn::make('description')->label('Details')->wrap(),
        ];
    }

    protected function getTableRecords(): Collection
    {
        $peopleWithoutManager = Person::query()->whereNull('manager_id')->where('status', 'active')->count();
        $overAllocated = Person::query()
            ->whereHas('assignments', function ($query) {
                $query->selectRaw('person_id, sum(allocation_percent) as total')
                    ->groupBy('person_id')
                    ->havingRaw('sum(allocation_percent) > 100');
            })->count();
        $assignmentsPastDue = Assignment::query()
            ->whereNotNull('end_date')
            ->where('end_date', '<', now())
            ->count();

        return collect([
            [
                'type' => 'People without manager',
                'count' => $peopleWithoutManager,
                'description' => 'Active people missing a manager assignment.',
            ],
            [
                'type' => 'Over-allocated people',
                'count' => $overAllocated,
                'description' => 'People exceeding 100% total allocation across projects.',
            ],
            [
                'type' => 'Assignments past due',
                'count' => $assignmentsPastDue,
                'description' => 'Assignments with an end date in the past but still active.',
            ],
        ]);
    }
}
