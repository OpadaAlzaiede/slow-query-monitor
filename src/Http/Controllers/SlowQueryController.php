<?php

namespace ObadaAz\SlowQueryMonitor\Http\Controllers;

use Illuminate\Routing\Controller;
use ObadaAz\SlowQueryMonitor\Models\SlowQuery;

class SlowQueryController extends Controller
{
    public function index() {

        $slowQueries = SlowQuery::latest()->get();
        return view('slowQueries::index', compact('slowQueries'));
    }

    public function destroy(SlowQuery $slowQuery) {

        $slowQuery->delete();
        return redirect()->route('slowQueries.index')->with('success', 'record deleted!');
    }

    public function clear() {
        
        SlowQuery::truncate();
        return redirect()->route('slowQueries.index')->with('success', 'Slow queries cleared!');
    }
}