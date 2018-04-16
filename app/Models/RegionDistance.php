<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionDistance extends Model
{
    protected $fillable = [
        "from", "to", "distance",
    ];
}
