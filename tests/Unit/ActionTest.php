<?php

namespace EventyTests\Unit;

use EventyTests\DummyClass;
use TorMorten\Eventy\Events;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    public function setUp()
    {
        $this->events = new Events;
    }

    /**
     * @test
     */
    public function it_can_hook_a_callable()
    {
        $this->events->addAction('my_awesome_action', function () {
            echo 'Action Fired, Baby!';
        });
        $this->expectOutputString('Action Fired, Baby!');
        $this->events->action('my_awesome_action');
    }

    /**
     * @test
     */
    public function it_can_hook_an_array()
    {
        $class = new class('DummyClass') {
            public function write()
            {
                echo 'Action Fired, Baby!';
            }
        };
        $this->events->addAction('my_amazing_action', [$class, 'write']);
        $this->expectOutputString('Action Fired, Baby!');
        $this->events->action('my_amazing_action');
    }

    /**
     * @test
     */
    public function a_hook_fires_even_if_there_are_two_listeners_with_the_same_priority()
    {
        $this->events->addAction('my_great_action', function () {
            echo 'Action Fired, Baby!';
        }, 20);

        $this->events->addAction('my_great_action', function () {
            echo 'Action Fired Again, Baby!';
        }, 20);

        $this->expectOutputString('Action Fired, Baby!Action Fired Again, Baby!');

        $this->events->action('my_great_action');
    }

    /**
     * @test
     */
    public function listeners_are_sorted_by_priority()
    {
        $this->events->addAction('my_great_action', function () {
            echo 'Action Fired, Baby!';
        }, 20);

        $this->events->addAction('my_great_action', function () {
            echo 'Action Fired, Baby!';
        }, 12);

        $this->events->addAction('my_great_action', function () {
            echo 'Action Fired, Baby!';
        }, 8);

        $this->events->addAction('my_great_action', function () {
            echo 'Action Fired, Baby!';
        }, 40);

        $this->assertEquals($this->events->getAction()->getListeners()->values()[0]['priority'], 8);
        $this->assertEquals($this->events->getAction()->getListeners()->values()[1]['priority'], 12);
        $this->assertEquals($this->events->getAction()->getListeners()->values()[2]['priority'], 20);
        $this->assertEquals($this->events->getAction()->getListeners()->values()[3]['priority'], 40);
    }
}
