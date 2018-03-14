<?php

namespace EventyTests\Unit;

use EventyTests\DummyClass;
use PHPUnit\Framework\TestCase;
use TorMorten\Eventy\Events;

class FilterTest extends TestCase
{
    public function setUp()
    {
        $this->events = new Events();
    }

    /**
     * @test
     */
    public function it_can_hook_a_callable()
    {
        $this->events->addFilter('my_awesome_filter', function ($value) {
            return $value.' Filtered';
        });
        $this->assertEquals($this->events->filter('my_awesome_filter', 'Value Was'), 'Value Was Filtered');
    }

    /**
     * @test
     */
    public function it_can_hook_an_array()
    {
        $class = new class('DummyClass') {
            public function filter($value)
            {
                return $value.' Filtered';
            }
        };
        $this->events->addFilter('my_amazing_filter', [$class, 'filter']);

        $this->assertEquals($this->events->filter('my_amazing_filter', 'Value Was'), 'Value Was Filtered');
    }

    /**
     * @test
     */
    public function a_hook_fires_even_if_there_are_two_listeners_with_the_same_priority()
    {
        $this->events->addFilter('my_great_filter', function ($value) {
            return $value.' Once';
        }, 20);

        $this->events->addFilter('my_great_filter', function ($value) {
            return $value.' And Twice';
        }, 20);

        $this->assertEquals($this->events->filter('my_great_filter', 'I Was Filtered'), 'I Was Filtered Once And Twice');
    }

    /**
     * @test
     */
    public function listeners_are_sorted_by_priority()
    {
        $this->events->addFilter('my_awesome_filter', function ($value) {
            return $value.' Filtered';
        }, 20);

        $this->events->addFilter('my_awesome_filter', function ($value) {
            return $value.' Filtered';
        }, 8);

        $this->events->addFilter('my_awesome_filter', function ($value) {
            return $value.' Filtered';
        }, 12);

        $this->events->addFilter('my_awesome_filter', function ($value) {
            return $value.' Filtered';
        }, 40);

        $this->assertEquals($this->events->getFilter()->getListeners()->values()[0]['priority'], 8);
        $this->assertEquals($this->events->getFilter()->getListeners()->values()[1]['priority'], 12);
        $this->assertEquals($this->events->getFilter()->getListeners()->values()[2]['priority'], 20);
        $this->assertEquals($this->events->getFilter()->getListeners()->values()[3]['priority'], 40);
    }
}
