<?php

namespace TorMorten\Eventy;

use SuperClosure\Serializer;

class HashedCallable
{
    protected $callback;
    protected $signature;

    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
        $this->id = $this->generateSignature();
    }

    protected function generateSignature()
    {
        $serializer = new Serializer();

        return base64_encode($serializer->serialize($this->callback));
    }

    public function __invoke()
    {
        return call_user_func_array($this->getCallback(), func_get_args());
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function is(self $callable)
    {
        return $callable->getSignature() === $this->getSignature();
    }
}
