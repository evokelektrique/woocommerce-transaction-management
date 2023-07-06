<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Vite::useScriptTagAttributes([
            'defer' => true,
        ]);

        View::composer('*', function ($view) {
            $view_name = str_replace('.', ' ', $view->getName());

            View::share('view_name', $view_name);
        });

        // Force HTTPS
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
