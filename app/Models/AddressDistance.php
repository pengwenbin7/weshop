<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressDistance extends Model
{
    protected $fillable = [
        "from", "to", "distance",
    ];
}
