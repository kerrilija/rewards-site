<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = ['contributor_id', 'cycle_id', 'platform', 'url', 'type', 'level', 'percentage', 'reward', 'comment', 'confirmed'];

    public function contributor()
    {
        return $this->belongsTo(Contributor::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    /**
     * Scope a query to filter contributions based on certain conditions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        // Filter by user (contributor) id
        $query->when($filters['user'] ?? null, function ($query, $userId) {
            $query->whereHas('contributor', function ($query) use ($userId) {
                $query->where('id', $userId);
            });
        });

        // Filter by cycle
        $query->when($filters['cycle'] ?? null, function ($query, $cycleId) {
            $query->whereHas('cycle', function ($query) use ($cycleId) {
                $query->where('id', $cycleId);
            });
        });

        // Filter by contribution type
        $query->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('type', $type);
        });
        
        // Filter by contributor name
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->whereHas('contributor', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        });

        return $query;
    }
}
