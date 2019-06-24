<?php

namespace EventyTests\Unit;

use PHPUnit\Framework\TestCase;
use TorMorten\Eventy\Events;
use TorMorten\Eventy\HashedCallable;

class HashedCallableTest extends TestCase
{
    public function setUp(): void
    {
        $this->events = new Events();
    }

    /**
     * @test
     */
    public function it_can_compare_two_callbacks()
    {
        $callback = function () {
            echo 'Action Fired, Baby!';
        };

        $this->events->addAction('my_awesome_action', $callback);

        $hashedCallable = new HashedCallable($callback);

        $this->assertTrue($this->events->getAction()->getListeners()->first()['callback']->is($hashedCallable));
    }

    /** @test * */
    public function it_can_remove_a_callback()
    {
        $callback = function () {
            echo 'Foo Bar';
        };

        $callback2 = function () {
            echo 'Foo Bars';
        };

        $this->events->addAction('my_great_action', $callback);
        $this->assertEquals($this->events->getAction()->getListeners()->count(), 1);

        $this->events->removeAction('my_great_action', $callback2);
        $this->assertEquals($this->events->getAction()->getListeners()->count(), 0);
    }
}
