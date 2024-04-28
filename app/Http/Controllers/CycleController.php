<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cycle;

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
}
