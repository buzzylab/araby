<?php

namespace Araby\Compress\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Compress

class CompressServiceProvider extends ServiceProvider
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
        $this->app->singleton('compress', function ($app) {
            return new Compress();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['compress'];
    }
}
