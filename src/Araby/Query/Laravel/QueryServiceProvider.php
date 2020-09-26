<?php

namespace ArabyPHP\Query\Laravel;

use ArabyPHP\Query\Query;
use Illuminate\Support\ServiceProvider;

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
