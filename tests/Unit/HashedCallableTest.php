<?php

namespace EventyTests\Unit;

use PHPUnit\Framework\TestCase;
use TorMorten\Eventy\Events;
use TorMorten\Eventy\HashedCallable;

class HashedCallableTest extends TestCase
{
    protected $events;

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

        $this->assertTrue($this->events->getAction()->getListeners('my_awesome_action')[0]['callback']->is($hashedCallable));
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
        $this->events->addAction('my_great_action', $callback2);

        $this->assertEquals(count($this->events->getAction()->getListeners('my_great_action')), 2);

        $this->events->removeAction('my_great_action', $callback2);

        $this->assertEquals(count($this->events->getAction()->getListeners('my_great_action')), 1);
    }
}
