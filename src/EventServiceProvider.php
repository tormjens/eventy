<?php

namespace TorMorten\Eventy;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Registers the eventy singleton
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Filter::class, function ($app) {
            return new Filter();
        });

        $this->app->singleton(Action::class, function ($app) {
            return new Action();
        });

        $this->app->singleton(Events::class, function ($app) {
            return new Events($this->make(Action::class), $this->make(Filter::class));
        });

        $this->app->instance('eventy', $this->app->make(Events::class));
        $this->app->instance('eventy.action', $this->app->make(Action::class));
        $this->app->instance('eventy.filter', $this->app->make(Filter::class));
    }
}
