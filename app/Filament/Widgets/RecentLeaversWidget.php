<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Person;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentLeaversWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Leavers';

    protected function getTableQuery(): Builder
    {
        return Person::query()->whereNotNull('leave_date')->where('leave_date', '>=', now()->subDays(30));
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Name'),
            TextColumn::make('employee_type')->label('Type'),
            TextColumn::make('leave_date')->dateTime()->label('Leave Date'),
        ];
    }
}
