<?php

namespace TorMorten\Eventy;

use Opis\Closure\SerializableClosure;

class HashedCallable
{
    /**
     * @var \Closure
     */
    protected $callback;

    /**
     * @var string
     */
    protected $signature;

    /**
     * HashedCallable constructor.
     * @param \Closure $callback
     */
    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
        $this->id = $this->generateSignature();
    }

    /**
     * Generate a unique signature for the callback.
     *
     * @return string|void
     */
    protected function generateSignature()
    {
        return base64_encode(
            serialize(
                new SerializableClosure($this->callback)
            )
        );
    }

    /**
     * Call the callback when the class is invoked
     * @return mixed|void
     */
    public function __invoke()
    {
        return call_user_func_array($this->getCallback(), func_get_args());
    }

    /**
     * Gets the signature
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Gets the callback
     * @return \Closure
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Checks whether the provided HashedCallable matches this one
     * @param HashedCallable $callable
     * @return bool
     */
    public function is(self $callable)
    {
        return $callable->getSignature() === $this->getSignature();
    }
}
