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
    
        $contributor = Contributor::firstOrCreate(
            ['name' => $requestData['name']],
            ['name' => $requestData['name']]
        );
    
        $rewardValue = $this->getRewardValue($requestData['type'], $requestData['level']);
    
        $args = [
            'contributor_id' => $contributor->id,
            'cycle_id' => $latestCycle->id,
            'platform' => $requestData['platform'],
            'url' => $requestData['url'],
            'type' => $requestData['type'],
            'level' => $requestData['level'],
            'reward' => $rewardValue,
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
    

private function getRewardValue($type, $level)
    {
        $reward = \App\Models\Reward::where('type', $type)->where('level', $level)->first();
        return $reward ? $reward->reward : null;
    }

    public function getLastContributions()
    {
        $lastContributions = Contribution::with(['contributor', 'cycle'])
                                         ->orderBy('id', 'desc')
                                         ->limit(5)
                                         ->get()
                                         ->map(function ($contribution) {
                                             return [
                                                 'id' => $contribution->id,
                                                 'contributor_name' => $contribution->contributor->name,
                                                 'cycle_id' => $contribution->cycle->id,
                                                 'platform' => $contribution->platform,
                                                 'url' => $contribution->url,
                                                 'type' => $contribution->type,
                                                 'level' => $contribution->level,
                                                 'percentage' => $contribution->percentage,
                                                 'reward' => $contribution->reward,
                                                 'confirmed' => $contribution->confirmed
                                             ];
                                         });
    
        return response()->json($lastContributions);
    }
    
}
