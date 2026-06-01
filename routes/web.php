<?php

use App\Http\Controllers\OilChangeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OilChangeController::class, 'index'])->name('oil-change.index');
Route::post('/check', [OilChangeController::class, 'check'])->name('oil-change.check');
Route::get('/result/{oilCheck}', [OilChangeController::class, 'result'])->name('oil-change.result');
