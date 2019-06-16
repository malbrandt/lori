<?php

namespace Malbrandt\Lori;

use Illuminate\Support\ServiceProvider;

class LoriServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'malbrandt');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'malbrandt');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole())
        {
            $this->bootForConsole();
        }
    }


    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        /*$this->publishes([
            __DIR__ . '/../config/lori.php' => config_path('lori.php'),
        ], 'lori.config');*/

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/malbrandt'),
        ], 'lori.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/malbrandt'),
        ], 'lori.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/malbrandt'),
        ], 'lori.views');*/

        // Registering package commands.
        // $this->commands([]);
    }


    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //$this->mergeConfigFrom(__DIR__ . '/../config/lori.php', 'lori');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [

        ];
    }
}
