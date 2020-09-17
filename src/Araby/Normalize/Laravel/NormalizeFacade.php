<?php

namespace Araby\Normalize\Laravel;

use Illuminate\Support\Facades\Facade;

class NormalizeFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'normalize';
    }
}
