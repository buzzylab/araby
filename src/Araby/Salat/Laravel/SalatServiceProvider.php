<?php

namespace ArabyPHP\Salat\Laravel;

use ArabyPHP\Salat\Salat;
use Illuminate\Support\ServiceProvider;

class SalatServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('salat', function ($app) {
            return new Salat();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['salat'];
    }
}
