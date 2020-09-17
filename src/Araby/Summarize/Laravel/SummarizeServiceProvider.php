<?php

namespace Araby\Summarize\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Summarize

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
