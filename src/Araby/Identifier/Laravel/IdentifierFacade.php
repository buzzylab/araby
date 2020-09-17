<?php

namespace Araby\Identifier\Laravel;

use Illuminate\Support\Facades\Facade;

class IdentifierFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'identifier';
    }
}
