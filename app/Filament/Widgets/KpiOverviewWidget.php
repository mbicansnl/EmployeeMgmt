<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Person;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KpiOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEmployees = Person::query()->where('employee_type', 'employee')->count();
        $totalContractors = Person::query()->where('employee_type', 'contractor')->count();
        $active = Person::query()->where('status', 'active')->count();
        $inactive = Person::query()->where('status', 'inactive')->count();

        return [
            Stat::make('Employees', $totalEmployees)
                ->description('Total active + inactive')
                ->color('primary'),
            Stat::make('Contractors', $totalContractors)
                ->description('Total active + inactive')
                ->color('warning'),
            Stat::make('Active', $active)->color('success'),
            Stat::make('Inactive', $inactive)->color('danger'),
        ];
    }
}
