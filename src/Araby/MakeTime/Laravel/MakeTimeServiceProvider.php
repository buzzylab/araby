<?php

namespace Araby\MakeTime\Laravel;

use Araby\MakeTime\MakeTime;
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
