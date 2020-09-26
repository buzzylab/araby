<?php

namespace ArabyPHP\Transliteration\Laravel;

use Illuminate\Support\Facades\Facade;

class TransliterationFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'transliteration';
    }
}
