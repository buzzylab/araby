<?php

namespace Araby\Standard\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Standard

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
