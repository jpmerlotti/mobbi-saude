<?php

namespace App\Providers\Filament;

use App\Filament\Clusters\Profile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Registration;
use App\Filament\Pages\Home;
use App\Filament\Widgets\EquipmentsList;
use Filament\Clusters\Cluster;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->font('Poppins')
            ->id('app')
            ->path('')
            ->login(Login::class)
            ->registration(Registration::class)
            // ->profile(Profile::class)
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn(): string => auth()->user()->name ?? 'Perfil')
                    ->url(fn() => Profile::getUrl()),
                'logout' => MenuItem::make('logout')
                    ->label('Sair')
            ])
            // ->darkMode(false)
            ->brandLogo(fn() => view('utils.brandLogo'))
            ->brandLogoHeight('6.5rem')
            ->colors([
                'primary' => Color::Sky,
                'secondary' => Color::Pink,
                '' => Color::Gray,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Home::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                EquipmentsList::class
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ])
            ->viteTheme('resources/css/filament/app/theme.css')
            ->breadcrumbs(false)
            ->renderHook(PanelsRenderHook::FOOTER, fn() => view('utils.footer'));
    }
}
