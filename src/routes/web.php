<?php

use Illuminate\Support\Facades\Route;
use ObadaAz\SlowQueryMonitor\Http\Controllers\SlowQueryController;

Route::middleware('web')->group(function () {
    Route::get('/slow-queries', [SlowQueryController::class, 'index'])->name('slowQueryMonitor.index');
    Route::delete('/slow-queries/{slowQuery}', [SlowQueryController::class, 'destroy'])->name('slowQueryMonitor.destroy');
    Route::delete('/slow-queries/clear', [SlowQueryController::class, 'clear'])->name('slowQueryMonitor.clear');
});

