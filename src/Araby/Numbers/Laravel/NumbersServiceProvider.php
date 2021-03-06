<?php

namespace ArabyPHP\Numbers\Laravel;

use ArabyPHP\Numbers\Numbers;
use Illuminate\Support\ServiceProvider;

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
