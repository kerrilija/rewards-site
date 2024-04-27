<?php

use App\Http\Controllers\ContributionController;
use Illuminate\Support\Facades\Route;

// Define your API route to get all contributions
Route::get('/contributions', [ContributionController::class, 'index']);
