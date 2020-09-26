<?php

namespace Araby\Soundex\Laravel;

use Araby\Soundex\Soundex;
use Illuminate\Support\ServiceProvider;

class SoundexServiceProvider extends ServiceProvider
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
        $this->app->singleton('soundex', function ($app) {
            return new Soundex();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['soundex'];
    }
}
