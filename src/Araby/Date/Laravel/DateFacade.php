<?php

namespace ArabyPHP\Date\Laravel;

use Illuminate\Support\Facades\Facade;

class DateFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'date';
    }
}
