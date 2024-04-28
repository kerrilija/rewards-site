<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\CycleController;
use Illuminate\Support\Facades\Route;

// Define your API route to get all contributions
Route::get('/contributions', [ContributionController::class, 'index']);
Route::get('/cycles/dates/{cycleId?}', [CycleController::class, 'getDates']);
