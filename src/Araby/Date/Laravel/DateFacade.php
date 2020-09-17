<?php

namespace Araby\Date\Laravel;

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
