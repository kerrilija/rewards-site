<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cycle;
use App\Models\Contribution;

class CycleController extends Controller
{
    /**
     * Get the start and end dates for a specific or the latest cycle.
     *
     * @param  int|null  $cycleId
     * @return \Illuminate\Http\Response
     */
    public function getDates($cycleId = null)
    {
        $cycleDates = Cycle::getCycleDates($cycleId);

        return response()->json($cycleDates);
    }

    public function getAggregatedCycleData($cycleId = null)
    {
        $cycle = Cycle::getCycleDates($cycleId);

        if (!$cycle || isset($cycle->error)) {
            return response()->json(['error' => 'Cycle not found'], 404);
        }

        $contributions = Contribution::with('contributor')
                                    ->where('cycle_id', $cycle->id)
                                    ->get();

        $contributorsRewards = [];
        $totalRewardsCycle = 0;

        foreach ($contributions as $contribution) {
            $contributorName = $contribution->contributor->name;
            if (!isset($contributorsRewards[$contributorName])) {
                $contributorsRewards[$contributorName] = 0;
            }
            $contributorsRewards[$contributorName] += $contribution->reward;
            $totalRewardsCycle += $contribution->reward;
        }

        $response = [
            'cycleId' => $cycle->id,
            'cycleStart' => $cycle->start,
            'cycleEnd' => $cycle->end,
            'contributorsRewards' => $contributorsRewards,
            'totalRewardsCycle' => $totalRewardsCycle
        ];

        return response()->json($response);
    }
}
