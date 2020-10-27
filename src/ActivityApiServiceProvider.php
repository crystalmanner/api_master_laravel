<?php

namespace FreshinUp\ActivityApi;

use FreshinUp\ActivityApi\Commands\Install;
use FreshinUp\ActivityApi\Commands\Link;
use FreshinUp\ActivityApi\Commands\Seed;
use FreshinUp\ActivityApi\Commands\Version;
use Illuminate\Support\ServiceProvider;

class ActivityApiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fresh-activity-api.php', 'fresh-activity-api');

        // Register the service the package provides.
        $this->app->singleton('fresh-activity-api', function ($app) {
            return new ActivityApi;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['fresh-activity-api'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/fresh-activity-api.php' => config_path('fresh-activity-api.php'),
        ], 'fresh-activity-api.config');

        // Registering package commands.
        $this->commands([
            Install::class,
            Version::class,
            Link::class,
            Seed::class
        ]);
    }
}
