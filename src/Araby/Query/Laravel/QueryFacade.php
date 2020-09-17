<?php

namespace Araby\Query\Laravel;

use Illuminate\Support\Facades\Facade;

class QueryFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'query';
    }
}
