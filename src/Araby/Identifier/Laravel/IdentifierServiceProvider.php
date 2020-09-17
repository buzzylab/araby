<?php

namespace Araby\Identifier\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Identifier

class IdentifierServiceProvider extends ServiceProvider
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
        $this->app->singleton('identifier', function ($app) {
            return new Identifier();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['identifier'];
    }
}
