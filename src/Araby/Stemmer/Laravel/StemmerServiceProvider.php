<?php

namespace Araby\Stemmer\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Stemmer

class StemmerServiceProvider extends ServiceProvider
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
        $this->app->singleton('stemmer', function ($app) {
            return new Stemmer();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['stemmer'];
    }
}
