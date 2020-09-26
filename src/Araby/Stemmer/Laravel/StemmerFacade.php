<?php

namespace ArabyPHP\Stemmer\Laravel;

use Illuminate\Support\Facades\Facade;

class StemmerFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'stemmer';
    }
}
