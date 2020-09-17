<?php

namespace Araby\MakeTime\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\MakeTime

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
