<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\ExceptionsWidget;
use App\Filament\Widgets\KpiOverviewWidget;
use App\Filament\Widgets\RecentJoinersWidget;
use App\Filament\Widgets\RecentLeaversWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class ManagementDashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Management Dashboard';

    public static function canAccess(): bool
    {
        return auth()->user()?->can('dashboards.view_management') ?? false;
    }

    public function getWidgets(): array
    {
        return [
            KpiOverviewWidget::class,
            RecentJoinersWidget::class,
            RecentLeaversWidget::class,
            ExceptionsWidget::class,
        ];
    }
}
