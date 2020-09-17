<?php

namespace Araby\Hiero\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Hiero

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
