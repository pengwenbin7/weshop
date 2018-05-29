<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrize extends Model
{
    protected $fillable = [
        "user_id", "amount", "note",
    ];
    
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}
