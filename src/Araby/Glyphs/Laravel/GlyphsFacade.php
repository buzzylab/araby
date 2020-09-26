<?php

namespace ArabyPHP\Glyphs\Laravel;

use Illuminate\Support\Facades\Facade;

class GlyphsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'glyphs';
    }
}
