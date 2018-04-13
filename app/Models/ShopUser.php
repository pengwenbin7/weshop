<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["openid", "rec_code"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function carts()
    {
        return $this->hasMany("App\Models\Cart", "user_id");
    }
    
    public function prizes()
    {
        return $this->hasMany("App\Models\UserPrize");
    }

    public function shareProducts()
    {
        return $this->hasMany("App\Models\UserShareProduct");
    }

    public function addresses()
    {
        return $this->hasManyThrough(
            "App\Models\Address",
            "App\Models\ShopUserAddress"
        );
    }
}
