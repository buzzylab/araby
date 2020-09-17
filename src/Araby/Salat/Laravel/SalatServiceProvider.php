<?php

namespace Araby\Salat\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Salat

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
