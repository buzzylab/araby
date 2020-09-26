<?php

namespace ArabyPHP\StrToTime\Laravel;

use ArabyPHP\StrToTime\StrToTime;
use Illuminate\Support\ServiceProvider;

class StrToTimeServiceProvider extends ServiceProvider
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
        $this->app->singleton('str-to-time', function ($app) {
            return new StrToTime();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['str-to-time'];
    }
}
