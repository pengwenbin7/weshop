<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * The admin usually means.
 * The "admin" user is an amazing user just like "root" in Unix.
 */

class AdminUser extends Authenticatable
{
    use HasRoles;
    
    protected $fillable = [
        "name", "password", "rec_code",
    ];

    protected $hidden = [
        "password", "remember_token",
    ];

    protected $guard_name = "admin";
}
