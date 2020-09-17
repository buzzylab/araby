<?php

namespace Araby\Numbers\Laravel;

use Illuminate\Support\Facades\Facade;

class NumbersFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'numbers';
    }
}
