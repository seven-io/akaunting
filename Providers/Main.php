<?php

namespace Modules\Sms77\Providers;

use Illuminate\Support\ServiceProvider as Provider;

class Main extends Provider {
    /**
     * Register the service provider.
     * @return void
     */
    public function register() {
        $this->loadRoutes();
    }

    /**
     * Boot the application events.
     * @return void
     */
    public function boot() {
        $this->loadViews();
        $this->loadTranslations();
    }

    /**
     * Load views.
     * @return void
     */
    public function loadViews() {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'sms77');
    }

    /**
     * Load translations.
     * @return void
     */
    public function loadTranslations() {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'sms77');
    }

    /**
     * Load routes.
     * @return void
     */
    public function loadRoutes() {
        if (app()->routesAreCached()) return;

        $routes = [
            'admin.php',
            'portal.php',
        ];

        foreach ($routes as $route)
            $this->loadRoutesFrom(__DIR__ . '/../Routes/' . $route);
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides() {
        return [];
    }
}
