<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{

    protected $fillable = [
        "name", "address_id",
    ];


    public function company()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function address()
    {
        return $this->belongsTo("App\Models\Address");
    }
}
