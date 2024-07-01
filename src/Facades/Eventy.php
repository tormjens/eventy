<?php

namespace TorMorten\Eventy\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TorMorten\Eventy\Events
 */
class Eventy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'eventy';
    }
}
