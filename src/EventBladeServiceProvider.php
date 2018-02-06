<?php

namespace TorMorten\Eventy;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class EventBladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Adds a directive in Blade for actions
         */
        Blade::directive('action', function ($expression) {
            return "<?php Eventy::action({$expression}); ?>";
        });

        /**
         * Adds a directive in Blade for filters
         */
        Blade::directive('filter', function ($expression) {
            return "<?php echo Eventy::filter({$expression}); ?>";
        });
    }
}
