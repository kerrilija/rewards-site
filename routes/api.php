<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\CycleController;
use Illuminate\Support\Facades\Route;

Route::get('/contributions', [ContributionController::class, 'index']);
Route::get('/cycles/dates/{cycleId?}', [CycleController::class, 'getDates']);
Route::post('/addcontribution', [ContributionController::class,'addContribution']);
