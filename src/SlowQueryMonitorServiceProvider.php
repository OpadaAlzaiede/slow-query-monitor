<?php

namespace ObadaAz\SlowQueryMonitor;

use Illuminate\Support\ServiceProvider;
use ObadaAz\SlowQueryMonitor\Console\Commands\ClearOldSlowQueriesLogCommand;

class SlowQueryMonitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('slowQueryMonitor', function () {
            return new \ObadaAz\SlowQueryMonitor\Services\SlowQueryMonitorService;
        });
    }

    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/../config/slowQueryMonitor.php' => config_path('slowQueryMonitor.php'),
        ]);

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'slowQueryMonitor');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearOldSlowQueriesLogCommand::class
            ]);
        }
    }
}