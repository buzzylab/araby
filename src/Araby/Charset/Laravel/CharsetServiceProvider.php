<?php

namespace ArabyPHP\Charset\Laravel;

use ArabyPHP\Charset\Charset;
use Illuminate\Support\ServiceProvider;

class CharsetServiceProvider extends ServiceProvider
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
        $this->app->singleton('charset', function ($app) {
            return new Charset();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['charset'];
    }
}
