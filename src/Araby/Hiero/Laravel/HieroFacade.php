<?php

namespace ArabyPHP\Hiero\Laravel;

use Illuminate\Support\Facades\Facade;

class HieroFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hiero';
    }
}
