<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;

class ContributionController extends Controller
{
    /**
     * Display a listing of the contributions, optionally filtered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve query parameters for filtering
        $filters = $request->only(['user', 'cycle', 'type', 'name']);

        // Fetch contributions applying filters
        $contributions = Contribution::filter($filters)->get();

        // Return the contributions as a JSON response
        return response()->json($contributions);
    }
}
