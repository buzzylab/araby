<?php

namespace ArabyPHP\Glyphs\Laravel;

use ArabyPHP\Glyphs\Glyphs;
use Illuminate\Support\ServiceProvider;

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
