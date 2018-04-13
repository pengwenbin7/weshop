<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopUserAddress extends Model
{
    protected $fillable = [
        "user_id", "address_id",
    ];
}
