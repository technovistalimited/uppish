<?php

namespace Technovistalimited\Uppish;

use Illuminate\Support\ServiceProvider;

class UppishServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // ----------------------------
        // PUBLISH --------------------
        // ----------------------------

        // config
        $this->publishes([__DIR__ . '/config/uppish.php' => config_path('uppish.php')], 'uppish');

        // views
        $this->publishes([__DIR__ .'/resources/views' => resource_path('views/vendor/uppish')], 'uppish');

        // language files
        $this->publishes([__DIR__ .'/resources/lang' => resource_path('lang/vendor/uppish')], 'uppish');

        // publish js and css files
        $this->publishes([__DIR__ .'/resources/assets' => public_path('vendor/uppish')], 'uppish');


        // ----------------------------
        // LOAD -----------------------
        // ----------------------------

        // config
        $this->mergeConfigFrom(__DIR__ . '/config/uppish.php', 'uppish');

        // routes
        $this->loadRoutesFrom(__DIR__ .'/routes/routes.php');

        // language files
        $this->loadTranslationsFrom(__DIR__ .'/resources/lang', 'uppish');

        // views
        $this->loadViewsFrom(__DIR__ .'/resources/views', 'uppish');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app['config']->get('uppish') === null) {
            $this->app['config']->set('uppish', require __DIR__ .'/config/uppish.php');
        }

        $this->app->singleton('uppish', function ($app) {
            return new Uppish();
        });
    }
}
