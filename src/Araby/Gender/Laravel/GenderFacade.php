<?php

namespace Araby\Gender\Laravel;

use Illuminate\Support\Facades\Facade;

class GenderFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gender';
    }
}
