<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function contribution()
    {
        return $this->hasMany(Contribution::class);
    }
}
