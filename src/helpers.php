<?php

if (!function_exists('eventy')) {

    /**
     * Get the Eventy instance
     *
     * @return TorMorten\Eventy\Facades\Events
     */
    function eventy()
    {
        return app('eventy');
    }
}

if (!function_exists('add_filter')) {

    /**
     * Add a filter to the Eventy instance
     *
     * @param string $hook
     * @param callable $function
     * @param int $priority
     * @param int $arguments
     *
     * @return void
     */
    function add_filter($hook, $callback, $priority = 20, $arguments = 1)
    {
        eventy()->addFilter($hook, $callback, $priority, $arguments);
    }
}


if (!function_exists('apply_filters')) {

    /**
     * Apply filters to a value
     *
     * @param string $action
     * @param mixed $value
     * @param mixed $parameters
     *
     * @return mixed
     */
    function apply_filters(string $action, $value, ...$parameters)
    {
        return eventy()->filter($action, $value, ...$parameters);
    }
}


if (!function_exists('add_action')) {

    /**
     * Add an action to the Eventy instance
     *
     * @param string $hook
     * @param callable $function
     * @param int $priority
     * @param int $arguments
     *
     * @return void
     */
    function add_action($hook, $callback, $priority = 20, $arguments = 1)
    {
        eventy()->addAction($hook, $callback, $priority, $arguments);
    }
}

if (!function_exists('do_action')) {

    /**
     * Execute the actions for the hook
     *
     * @param string $hook
     * @param mixed $parameters
     *
     * @return void
     */
    function do_action(string $action, ...$parameters)
    {
        eventy()->action($action, ...$parameters);
    }
}
