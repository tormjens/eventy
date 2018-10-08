<?php

namespace TorMorten\Eventy;

class Events
{

    /**
     * Holds all registered actions
     * @var Action
     */
    protected $action;

    /**
     * Holds all registered filters
     * @var Filter
     */
    protected $filter;

    /**
     * Construct the class
     * @param null|Action $action
     * @param null|Filter $filter
     */
    public function __construct(?Action $action = null, ?Filter $filter = null)
    {
        if (!$action) {
            $this->action = new Action();
        }
        if (!$filter) {
            $this->filter = new Filter();
        }
    }

    /**
     * Get the action instance
     * @return Action
     */
    public function getAction()
    {
        return $this->action;
    }


    /**
     * Get the action instance
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Add an action
     * @param string $hook Hook name
     * @param mixed $callback Function to execute
     * @param integer $priority Priority of the action
     * @param integer $arguments Number of arguments to accept
     *
     * @return Events
     */
    public function addAction($hook, $callback, $priority = 20, $arguments = 1)
    {
        $this->action->listen($hook, $callback, $priority, $arguments);

        return $this;
    }

    /**
     * Adds a filter
     * @param string $hook Hook name
     * @param mixed $callback Function to execute
     * @param integer $priority Priority of the action
     * @param integer $arguments Number of arguments to accept
     *
     * @return Events
     */
    public function addFilter($hook, $callback, $priority = 20, $arguments = 1)
    {
        $this->filter->listen($hook, $callback, $priority, $arguments);

        return $this;
    }

    /**
     * Set a new action
     *
     * Actions never return anything. It is merely a way of executing code at a specific time in your code.
     *
     * You can add as many parameters as you'd like.
     *
     * @param array ...$args First argument will be the name of the hook, and the rest will be args for the hook.
     *
     * @return void
     */
    public function action(...$args)
    {
        $hook = $this->createHook($args);
        $this->action->fire($hook->name, $hook->args);
    }

    /**
     * Set a new filter
     *
     * Filters should always return something. The first parameter will always be the default value.
     *
     * You can add as many parameters as you'd like.
     *
     * @param array ...$args First argument will be the name of the hook, and the rest will be args for the hook.
     *
     * @return mixed
     */
    public function filter(...$args)
    {
        $hook = $this->createHook($args);
        return $this->filter->fire($hook->name, $hook->args);
    }

    /**
     * Figures out the hook
     *
     * Will return an object with two keys. One for the name and one for the arguments that will be
     * passed to the hook itself.
     *
     * @param mixed ...$args
     *
     * @return \stdClass
     */
    protected function createHook($args)
    {
        return (object)[
            'name' => $args[0],
            'args' => array_values(array_slice($args, 1))
        ];
    }

}