<?php

namespace Araby\Salat\Laravel;

use Illuminate\Support\Facades\Facade;

class SalatFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'salat';
    }
}
