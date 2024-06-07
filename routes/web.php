<?php

use App\Http\Controllers\ContributionWebController;

Route::get('/', [ContributionWebController::class, 'index']);
