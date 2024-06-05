<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use Carbon\Carbon;

class AppendCycle extends Command
{
    protected $signature = 'cycle:append';
    protected $description = 'Append a new cycle if the current cycle has ended';

    public function handle()
    {
        $latestCycle = Cycle::latest('end')->first();

        if ($latestCycle && new Carbon($latestCycle->end) < now()) {
            $newCycle = Cycle::create([
                'start' => Carbon::parse($latestCycle->end)->addDay(),
                'end' => Carbon::parse($latestCycle->end)->addDays(28),
            ]);

            $this->info('Created new cycle with ID: ' . $newCycle->id);
        } else {
            $this->info('No new cycle needed today.');
        }
    }
}
