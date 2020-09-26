<?php

namespace ArabyPHP\Summarize\Laravel;

use Illuminate\Support\Facades\Facade;

class SummarizeFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'summarize';
    }
}
