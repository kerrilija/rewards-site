<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;

class ContributionController extends Controller
{
    public function index()
    {
        $contributions = Contribution::all();
        return response()->json($contributions);
    }
}
