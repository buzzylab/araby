<?php

namespace Araby\Soundex\Laravel;

use Illuminate\Support\Facades\Facade;

class SoundexFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'soundex';
    }
}
