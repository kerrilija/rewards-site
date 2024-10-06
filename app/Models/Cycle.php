<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;

    protected $fillable = ['start', 'end']; // Define fillable properties

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    /**
     * Get the start and end dates for a cycle. If no ID is provided, returns the latest cycle.
     *
     * @param int|null $cycleId Optional. The ID of the cycle, or null to fetch the latest cycle.
     * @return object An object containing the start and end dates, or an error if not found.
     */
    public static function getCycleDates($cycleId = null)
    {
        $cycle = $cycleId ? self::find($cycleId) : self::orderBy('id', 'desc')->first();

        if (!$cycle) {
            return (object)['error' => 'Cycle not found'];
        }

        return (object)[
            'id' => $cycle->id,
            'start' => $cycle->start,
            'end' => $cycle->end
        ];
    }
}
