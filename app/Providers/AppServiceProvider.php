<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
        // Share contact info with all public views
        View::composer(['welcome', 'contact', 'about', 'components.public-footer', 'components.public-navbar'], function ($view) {
            if (Schema::hasTable('settings')) {
                $view->with('contactInfo', Setting::getContactInfo());
            }
        });
    }
}
