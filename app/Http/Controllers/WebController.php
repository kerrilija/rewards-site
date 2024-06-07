<?php

namespace App\Http\Controllers;

use App\Models\Contribution;

class WebController extends Controller
{
    public function showContributions()
    {
        $contributions = Contribution::with('contributor')->get();
        return view('contributions', ['contributions' => $contributions]);
    }
}

