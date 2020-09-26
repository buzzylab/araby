<?php

namespace ArabyPHP\MakeTime\Laravel;

use Illuminate\Support\Facades\Facade;

class MakeTimeFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'make-time';
    }
}
