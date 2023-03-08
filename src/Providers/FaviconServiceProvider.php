<?php

namespace Chriscreates\Favicon\Providers;

use Chriscreates\Favicon\Commands\GenerateFaviconImagesCommand;
use Illuminate\Support\ServiceProvider;

class FaviconServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'favicon');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/favicon'),
        ], 'favicon-views');

        $this->publishes([
            __DIR__.'/../../config/favicon.php' => config_path('favicon.php'),
        ], 'favicon-config');


        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateFaviconImagesCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->registerConfiguration();
    }

    protected function registerConfiguration()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/favicon.php',
            'favicon'
        );
    }
}
