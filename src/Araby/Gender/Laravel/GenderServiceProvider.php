<?php

namespace ArabyPHP\Gender\Laravel;

use ArabyPHP\Gender\Gender;
use Illuminate\Support\ServiceProvider;

class GenderServiceProvider extends ServiceProvider
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
        $this->app->singleton('gender', function ($app) {
            return new Gender();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['gender'];
    }
}
