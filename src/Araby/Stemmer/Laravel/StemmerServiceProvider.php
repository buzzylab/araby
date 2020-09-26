<?php

namespace ArabyPHP\Stemmer\Laravel;

use ArabyPHP\Stemmer\Stemmer;
use Illuminate\Support\ServiceProvider;

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
