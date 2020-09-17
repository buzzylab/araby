<?php

namespace Araby\Query\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Query

class QueryServiceProvider extends ServiceProvider
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
        $this->app->singleton('query', function ($app) {
            return new Query();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['query'];
    }
}
