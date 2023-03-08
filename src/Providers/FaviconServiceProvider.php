<?php

namespace Chriscreates\Favicon\Providers;

use Illuminate\Support\ServiceProvider;

class FaviconServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootPublishesConfig();
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

    private function bootPublishesConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/favicon.php' => config_path('favicon.php'),
        ], 'favicon-config');
    }
}
