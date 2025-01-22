<?php

namespace ObadaAz\SlowQueryMonitor\Facades;

use Illuminate\Support\Facades\Facade;

class SlowQueryMonitorFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor() {

        return 'slowQueryMonitor';
    }
}