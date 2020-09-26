<?php

namespace Araby\Identifier\Laravel;

use Araby\Identifier\Identifier;
use Illuminate\Support\ServiceProvider;

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
