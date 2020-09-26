<?php

namespace ArabyPHP\WordTag\Laravel;

use Illuminate\Support\Facades\Facade;

class WordTagFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'word-tag';
    }
}
