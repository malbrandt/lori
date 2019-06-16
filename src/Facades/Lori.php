<?php

namespace Malbrandt\Lori\Facades;

use Illuminate\Support\Facades\Facade;

class Lori extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lori';
    }
}
