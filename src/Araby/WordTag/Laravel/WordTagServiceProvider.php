<?php

namespace ArabyPHP\WordTag\Laravel;

use ArabyPHP\WordTag\WordTag;
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
