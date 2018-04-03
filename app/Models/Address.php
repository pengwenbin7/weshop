<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        "contact_name", "contact_tel", "country",
        "province", "city", "detail", "city_adcode",
        "city_center",
    ];
}
