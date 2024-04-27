<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    public function contributor()
    {
        return $this->belongsTo(Contributor::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }
}
