<?php

namespace Araby\Gender\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Gender

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
