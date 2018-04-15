<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "openid", "name", "phone", "password", "rec_code",
    ];

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

    public function userAddresses() {
        return $this->hasMany("App\Models\UserAddress");
    }

    public function primaryUserAddress() {
        $primary = $this->userAddresses()
                 ->where("is_primary", "=", 1)
                 ->orderBy("updated_at", "desc")
                 ->first();
        return $primary;
    }
    
    public function addresses()
    {
        return $this->belongsToMany(
            "App\Models\Address",
            "user_addresses",
            "user_id",
            "address_id"
        );
    }
}
