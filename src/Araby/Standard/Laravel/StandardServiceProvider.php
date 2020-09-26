<?php

namespace Araby\Standard\Laravel;

use Araby\Standard\Standard;
use Illuminate\Support\ServiceProvider;

class StandardServiceProvider extends ServiceProvider
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
        $this->app->singleton('standard', function ($app) {
            return new Standard();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['standard'];
    }
}
