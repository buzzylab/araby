<?php

namespace ArabyPHP\Hiero\Laravel;

use ArabyPHP\Hiero\Hiero;
use Illuminate\Support\ServiceProvider;

class HieroServiceProvider extends ServiceProvider
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
        $this->app->singleton('hiero', function ($app) {
            return new Hiero();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['hiero'];
    }
}
