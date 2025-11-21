<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            "primary"=> [
                50 => '#F0F9FF',
               100 => '#E0F3FF',
               200 => '#BAE6FD',
               300 => '#7DD3FC',
               400 => '#38BDF8',
               500 => '#0EA5E9',
               600 => '#0284C7',
               700 => '#0369A1',
               800 => '#075985',
               900 => '#0C4A6E',
            ], "secondary" => [
                50 => '#FDF2F8',
               100 => '#FCE7F3',
               200 => '#FBCFE8',
               300 => '#F9A8D4',
               400 => '#F472B6',
               500 => '#EC4899',
               600 => '#DB2777',
               700 => '#BE185E',
               800 => '#9D174D',
               900 => '#831843',
            ],
        ]);
    }
}
