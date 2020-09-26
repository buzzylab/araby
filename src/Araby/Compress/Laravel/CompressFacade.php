<?php

namespace ArabyPHP\Compress\Laravel;

use Illuminate\Support\Facades\Facade;

class CompressFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'compress';
    }
}
