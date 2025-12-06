<?php

namespace App\Providers;
use Session;
use App\Models\AccountingAccountTransaction;
use App\Models\CarExpense;
use App\Models\CarInventoryInstallment;
use App\Models\CarMaintenance;
use App\Observers\AccountTransactionObserver;
use App\Observers\CarExpenseObserver;
use App\Observers\CarInventoryInstallmentObserver;
use App\Observers\CarMaintenanceObserver;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Support\Assets\AlpineComponent;
use Illuminate\Support\ServiceProvider;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\App;

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
        FilamentAsset::register([
            Js::make('filamnet-custom', asset('js/filamnet-custom.js') . '?v=' . time()),
        ]);

        FilamentAsset::register([
            AlpineComponent::make('location-picker-input', asset('/js/location-picker-input.js')),
        ], package: 'app');
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {

            $switch
                ->locales(config('app.locales'))
                ->when(config('app.locale'), function ($switch) {
                    Session::put('filament_language_switch_locale', session('locale', config('app.locale')));
                    App::setLocale(session('locale', config('app.locale')));
                });
        });
    }
}
