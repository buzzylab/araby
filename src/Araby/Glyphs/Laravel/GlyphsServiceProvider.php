<?php

namespace Araby\Glyphs\Laravel;

use Illuminate\Support\ServiceProvider;
use Araby\Glyphs

class GlyphsServiceProvider extends ServiceProvider
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
        $this->app->singleton('glyphs', function ($app) {
            return new Glyphs();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['glyphs'];
    }
}
