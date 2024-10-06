<?php

use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'index']);