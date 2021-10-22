<?php

namespace TorMorten\Eventy;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EventBladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->has('blade.compiler')) {
            /*
             * Adds a directive in Blade for actions
             */
            Blade::directive('action', function ($expression) {
                return "<?php app('eventy')->action({$expression}); ?>";
            });

            /*
             * Adds a directive in Blade for filters
             */
            Blade::directive('filter', function ($expression) {
                return "<?php echo app('eventy')->filter({$expression}); ?>";
            });
        }
    }
}
