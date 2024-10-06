<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\CycleController;
use Illuminate\Support\Facades\Route;

Route::get('/contributions', [ContributionController::class, 'index']);
Route::get('/contributions/last', [ContributionController::class, 'getLastContributions']);
Route::get('/cycles/dates/{cycleId?}', [CycleController::class, 'getDates']);
Route::get('/cycles/aggregated/{cycleId?}', [CycleController::class, 'getAggregatedCycleData']);
Route::post('/addcontribution', [ContributionController::class,'addContribution']);
