<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Pages\ManagementDashboard;
use App\Filament\Resources\AssignmentResource;
use App\Filament\Resources\DomainResource;
use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\PersonResource;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\RoleResource;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::hex('#01324b'),
                'secondary' => Color::hex('#0070a8'),
                'warning' => Color::hex('#f58220'),
                'info' => Color::hex('#0088cc'),
            ])
            ->font('Merriweather Sans')
            ->resources([
                PersonResource::class,
                DomainResource::class,
                ProjectResource::class,
                AssignmentResource::class,
                RoleResource::class,
                PermissionResource::class,
            ])
            ->pages([
                ManagementDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ])
            ->authMiddleware([
                \Illuminate\Auth\Middleware\Authenticate::class,
            ])
            ->login();
    }
}
