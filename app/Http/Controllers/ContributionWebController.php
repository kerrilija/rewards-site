<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionWebController extends Controller
{
    public function index()
    {
        $contributions = Contribution::with('contributor')->get();
        return view('contributions', compact('contributions'));
    }
}

