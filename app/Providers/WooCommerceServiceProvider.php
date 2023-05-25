<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Automattic\WooCommerce\Client;

class WooCommerceServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(Client::class, function () {
            return new Client(
                env("WOOCOMMERCE_BASE_URL"),
                env("WOOCOMMERCE_API_KEY_CK"),
                env("WOOCOMMERCE_API_KEY_CS"),
                [
                    'version' => 'wc/v3',
                ]
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
