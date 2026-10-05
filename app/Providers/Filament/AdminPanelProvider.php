<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Memuat file tema custom (public/custom-filament.css).
        // Pastikan isi file ini adalah versi TERANG (theme.css yang sudah dikirim),
        // bukan lagi versi gelap.
        FilamentView::registerRenderHook(
            'panels::styles.after',
            fn(): string => Blade::render('
                <link rel="stylesheet" href="{{ asset(\'custom-filament.css\') }}?v=' . time() . '">
            '),
        );

        // CATATAN: blok <style> tema gelap yang sebelumnya di-inject lewat
        // registerRenderHook('panels::head.end', ...) SUDAH DIHAPUS di sini.
        // Blok itu berisi override dark-mode dengan !important yang selalu
        // menimpa custom-filament.css di atas, apapun isi file CSS-nya.
        // Kalau butuh override tambahan di masa depan, taruh langsung di
        // public/custom-filament.css, JANGAN pakai render hook terpisah lagi
        // supaya tidak terjadi konflik urutan seperti ini.

        FilamentAsset::register([
            Js::make('nav-animation', asset('js/nav-animation.js')),
        ]);

        return $panel
            ->spa()
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Univ Malikussaleh')
            ->favicon(asset('Logo.png'))
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->darkMode(false) // <-- diubah dari isForced: true, supaya tidak dipaksa dark
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\SapaanWidget::class,
                \App\Filament\Widgets\JadwalHariIniWidget::class,
                \App\Filament\Widgets\AsetPerluPerhatianWidget::class,
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
