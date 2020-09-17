<?php

namespace Araby\KeySwap\Laravel;

use Illuminate\Support\Facades\Facade;

class KeySwapFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'key-swap';
    }
}
