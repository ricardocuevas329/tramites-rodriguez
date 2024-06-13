<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
          URL::forceScheme('https');
        }
        if($this->app->environment('local')) {
            //  $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            //  $this->app->register(TelescopeServiceProvider::class);
        }
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_PE', 'es', 'ES', 'es_PE.utf8');


        Validator::extend('alpha_spaces', function ($attribute, $value) {

            return preg_match('/^[\pL\s]+$/u', $value);

        });
    }
}
