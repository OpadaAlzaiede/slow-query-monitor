<?php

namespace ObadaAz\SlowQueryMonitor\Services;

use ObadaAz\SlowQueryMonitor\Models\SlowQuery;
use Illuminate\Support\Facades\DB;

class SlowQueryMonitorService
{
    protected $enabled;
    protected $threshold;

    public function __construct() {

        $this->enabled = (bool) env('SLOW_QUERY_MONITOR_ENABLED', true);
        $this->threshold = (float) env('SLOW_QUERY_MONITOR_THRESHOLD', 1000);
    }

    public function monitor(): void {

        if (!$this->enabled) {
            return;
        }

        DB::listen(function ($query) {
            $executionTime = $query->time;

            if ($executionTime > $this->threshold) {
                // Get the file and line where the query was executed
                $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
                $file = '';
                $line = 0;

                foreach ($backtrace as $trace) {
                    if (isset($trace['file']) && !str_contains($trace['file'], 'vendor')) {
                        $file = $trace['file'];
                        $line = $trace['line'];
                        break;
                    }
                }

                // Determine the query type
                $queryType = strtoupper(explode(' ', trim($query->sql))[0]);

                // Analyze the query for potential slowness reasons
                $reason = $this->analyzeQuery($query->sql);

                // Log the slow query
                SlowQuery::create([
                    'query' => $query->sql,
                    'type' => $queryType,
                    'execution_time' => $executionTime,
                    'file' => $file,
                    'line' => $line,
                    'response' => null, // You can log the response if needed
                    'reason' => $reason,
                    'executed_at' => now(),
                ]);
            }
        });
    }

    protected function analyzeQuery(string $sql): string {

        if (str_contains($sql, 'SELECT *')) {
            return 'Using SELECT * can cause performance issues. Specify columns explicitly.';
        }

        if (str_contains($sql, 'JOIN') && !str_contains($sql, 'INDEX')) {
            return 'Missing index on joined columns.';
        }

        if (str_contains($sql, 'LIKE %')) {
            return 'Leading wildcard in LIKE clause can cause full table scans.';
        }

        return 'No obvious issues detected. Check for missing indexes or large datasets.';
    }
}