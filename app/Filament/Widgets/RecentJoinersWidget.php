<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Person;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentJoinersWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Joiners';

    protected function getTableQuery(): Builder
    {
        return Person::query()->where('join_date', '>=', now()->subDays(30));
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Name'),
            TextColumn::make('employee_type')->label('Type'),
            TextColumn::make('join_date')->date()->label('Join Date'),
        ];
    }
}
