<?php

namespace ArabyPHP\MakeTime\Laravel;

use ArabyPHP\MakeTime\MakeTime;
use Illuminate\Support\ServiceProvider;

class MakeTimeServiceProvider extends ServiceProvider
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
        $this->app->singleton('make-time', function ($app) {
            return new MakeTime();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['make-time'];
    }
}
