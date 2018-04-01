<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierUser extends Model
{
    public function brands()
    {
        return $this->hasMany("App\Models\Brand");
    }
}
