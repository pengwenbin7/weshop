<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{

    protected $fillable = [
        "name", "oper_name", "code",
        "admin_id",
    ];

    public function admin()
    {
        return $this->belongsTo("App\Models\AdminUser", "admin_id");
    }
}
