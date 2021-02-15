<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        dd($_ENV);

        $env = env('APP_ENV');
        dd(['APP_ENV value: ' => $env]);

        if($this->app->environment('production')) {
            //\URL::forceScheme('https');
            //dd(['message' => 'stooop']);
            //$this->app['request']->server->set('HTTPS', true);
            $env = env('APP_ENV');
            dd(['APP_ENV value: ' => $env]);
            URL::forceScheme('https');
        }
    }
}
