<?php

namespace ObadaAz\SlowQueryMonitor\Console\Commands;

use Illuminate\Console\Command;
use ObadaAz\SlowQueryMonitor\Models\SlowQuery;

class ClearOldSlowQueriesLogCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slow-queries-log:clear';

    /**
     * Execute the console command.
     */
    public function handle(): void {

        SlowQuery::query()
                ->where('created_at', '<=', now()->subWeek())
                ->delete();
    }
}