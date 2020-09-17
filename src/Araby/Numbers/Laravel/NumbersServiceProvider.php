<?php

namespace Araby\Numbers\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Numbers

class NumbersServiceProvider extends ServiceProvider
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
        $this->app->singleton('numbers', function ($app) {
            return new Numbers();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['numbers'];
    }
}
