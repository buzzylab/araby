<?php

namespace ArabyPHP\Compress\Laravel;

use ArabyPHP\Compress\Compress;
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
