<?php

namespace ObadaAz\SlowQueryMonitor\Middleware;

use Closure;
use ObadaAz\SlowQueryMonitor\Facades\SlowQueryMonitorFacade;

class SlowQueryMonitorMiddleware
{

    public function handle($request, Closure $next) {

        SlowQueryMonitorFacade::monitor();

        return $next($request);
    }
}