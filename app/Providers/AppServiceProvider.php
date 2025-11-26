<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\SalonComposer;
use App\Models\Salon;
use App\Observers\SalonObserver;

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
        // Register view composer for salon dashboard layout
        View::composer('layouts.salon-dashboard', SalonComposer::class);
        
        // Register Salon observer for automatic hosts file updates
        Salon::observe(SalonObserver::class);
    }
}
