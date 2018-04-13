<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

class UserShareProduct extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }
}
