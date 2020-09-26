<?php

namespace Araby\WordTag\Laravel;

use Araby\WordTag\WordTag;
use Illuminate\Support\ServiceProvider;

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
