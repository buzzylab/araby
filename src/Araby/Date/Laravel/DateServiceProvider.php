<?php

namespace Araby\Date\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Date

class DateServiceProvider extends ServiceProvider
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
        $this->app->singleton('date', function ($app) {
            return new Date();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['date'];
    }
}
