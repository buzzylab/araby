<?php

namespace ArabyPHP\Standard\Laravel;

use Illuminate\Support\Facades\Facade;

class StandardFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'standard';
    }
}
