<?php

namespace ArabyPHP\Summarize\Laravel;

use ArabyPHP\Summarize\Summarize;
use Illuminate\Support\ServiceProvider;

class SummarizeServiceProvider extends ServiceProvider
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
        $this->app->singleton('summarize', function ($app) {
            return new Summarize();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['summarize'];
    }
}
