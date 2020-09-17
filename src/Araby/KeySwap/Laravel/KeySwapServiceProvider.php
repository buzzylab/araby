<?php

namespace Araby\KeySwap\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\KeySwap

class KeySwapServiceProvider extends ServiceProvider
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
        $this->app->singleton('key-swap', function ($app) {
            return new KeySwap();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['key-swap'];
    }
}
