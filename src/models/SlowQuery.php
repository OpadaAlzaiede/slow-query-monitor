<?php

namespace ObadaAz\SlowQueryMonitor\Models;

use Illuminate\Database\Eloquent\Model;

class SlowQuery extends Model
{
    protected $table = 'slow_queries';
    protected $fillable = [
        'query',
        'type',
        'execution_time',
        'file',
        'line',
        'response',
        'reason',
        'executed_at',
    ];
}