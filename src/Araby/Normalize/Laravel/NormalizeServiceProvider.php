<?php

namespace Araby\Normalize\Laravel;

use Araby\Normalize\Normalize;
use Illuminate\Support\ServiceProvider;

class NormalizeServiceProvider extends ServiceProvider
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
        $this->app->singleton('normalize', function ($app) {
            return new Normalize();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['normalize'];
    }
}
