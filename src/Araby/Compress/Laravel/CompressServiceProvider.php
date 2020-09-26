<?php

namespace Araby\Compress\Laravel;

use Araby\Compress\Compress;
use Illuminate\Support\ServiceProvider;

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
