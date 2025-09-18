<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/admin')
            ->colors([
                'primary' => [
                    50 => '#EFF6FF',
                    100 => '#DBEAFE',
                    200 => '#C2D5FF',
                    300 => '#96B7FF',
                    400 => '#6394FF',
                    500 => '#3A75F6',
                    600 => '#2563EB', // Main MYDS Blue
                    700 => '#1D4ED8',
                    800 => '#1E40AF',
                    900 => '#1E3A8A',
                    950 => '#172554',
                ],
                'danger' => [
                    50 => '#FEF2F2',
                    100 => '#FEE2E2',
                    200 => '#FECACA',
                    300 => '#FCA5A5',
                    400 => '#F87171',
                    500 => '#EF4444',
                    600 => '#DC2626',
                    700 => '#B91C1C',
                    800 => '#991B1B',
                    900 => '#7F1D1D',
                    950 => '#450A0A',
                ],
                'success' => [
                    50 => '#F0FDF4',
                    100 => '#DCFCE7',
                    200 => '#BBF7D0',
                    300 => '#83DAA3',
                    400 => '#4ADE80',
                    500 => '#22C55E',
                    600 => '#16A34A',
                    700 => '#15803D',
                    800 => '#166534',
                    900 => '#14532D',
                    950 => '#052E16',
                ],
                'warning' => [
                    50 => '#FEFCE8',
                    100 => '#FEF9C3',
                    200 => '#FEF08A',
                    300 => '#FDE047',
                    400 => '#FACC15',
                    500 => '#EAB308',
                    600 => '#CA8A04',
                    700 => '#A16207',
                    800 => '#854D0E',
                    900 => '#713F12',
                    950 => '#422006',
                ],
                'gray' => [
                    50 => '#FAFAFA',
                    100 => '#F4F4F5',
                    200 => '#E4E4E7',
                    300 => '#D4D4D8',
                    400 => '#A1A1AA',
                    500 => '#71717A',
                    600 => '#52525B',
                    700 => '#3F3F46',
                    800 => '#27272A',
                    900 => '#18181B',
                    950 => '#09090B',
                ],
            ])
            ->font('Inter')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\MydsCompliantDashboard::class,
                \App\Filament\Pages\HelpDocumentation::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}