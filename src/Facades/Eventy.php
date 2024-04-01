<?php

namespace TorMorten\Eventy\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void addFilter(string $hook, callable $callback, int $priority = 20, int $arguments = 1)
 * @method static mixed filter(string $action, $value, ...$parameters)
 * @method static void addAction(string $hook, callable $callback, int $priority = 20, int $arguments = 1)
 * @method static void action(string $action, ...$parameters)
 *
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
