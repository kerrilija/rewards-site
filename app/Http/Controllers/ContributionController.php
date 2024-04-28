<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Cycle;
use Illuminate\Http\Response;
use App\Models\Contributor;


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

        $contributions = Contribution::filter($filters)->get();

        return response()->json($contributions);
    }

    public function addContribution(Request $request)
{
    $latestCycle = Cycle::getCycleDates();

    if (isset($latestCycle->error)) {
        return response()->json(['error' => $latestCycle->error], Response::HTTP_BAD_REQUEST);
    }

    $requestData = $request->only(['name', 'platform', 'url', 'type', 'level']);

    $contributor = Contributor::where('name', $requestData['name'])->first();

    if (!$contributor) {
        return response()->json(['error' => 'Contributor not found'], Response::HTTP_NOT_FOUND);
    }

    $args = [
        'contributor_id' => $contributor->id,
        'cycle_id' => $latestCycle->id,
        'platform' => $requestData['platform'],
        'url' => $requestData['url'],
        'type' => $requestData['type'],
        'level' => $requestData['level'],
        'confirmed' => false,
        'percentage' => 1
    ];

    $contribution = Contribution::create($args);

    if ($contribution) {
        return response()->json($contribution, Response::HTTP_CREATED);
    } else {
        return response()->json(['error' => 'Failed to create the contribution'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

}
