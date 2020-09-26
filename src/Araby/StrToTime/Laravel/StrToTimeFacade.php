<?php

namespace ArabyPHP\StrToTime\Laravel;

use Illuminate\Support\Facades\Facade;

class StrToTimeFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'str-to-time';
    }
}
