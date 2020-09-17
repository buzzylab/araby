<?php

namespace Araby\WordTag\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\WordTag

class WordTagServiceProvider extends ServiceProvider
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
        $this->app->singleton('word-tag', function ($app) {
            return new WordTag();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['word-tag'];
    }
}
