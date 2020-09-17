<?php

namespace Araby\Charset\Laravel;

use Illuminate\Support\Facades\Facade;

class CharsetFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'charset';
    }
}
