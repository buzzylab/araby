<?php

namespace ArabyPHP\Date\Laravel;

use ArabyPHP\Date\Date;
use Illuminate\Support\ServiceProvider;

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
