<?php

namespace Tormjens\Eventy;

class HashedCallable
{
    protected $callback;
    protected $id;

    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
        $this->id = uniqid();
    }

    public function __invoke()
    {
        return call_user_func_array($this->callback, func_get_args());
    }

    public function getId()
    {
        return $this->id;
    }
}