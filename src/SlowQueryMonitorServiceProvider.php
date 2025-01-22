<?php

namespace ObadaAz\SlowQueryMonitor;

use Illuminate\Support\ServiceProvider;

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
        ], 'config');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'slowQueryMonitor');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../Database/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}