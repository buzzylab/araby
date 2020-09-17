<?php

namespace Araby\Charset\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Charset

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
