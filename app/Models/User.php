<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use EasyWeChat;

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
        return $this->hasMany("App\Models\Cart");
    }

    public function cartItems()
    {
        return $this->hasManyThrough("App\Models\CartItem", "App\Models\Cart");
    }

    public function orders()
    {
        return $this->hasMany("App\Models\Order");
    }

    public function coupons()
    {
        return $this->hasMany("App\Models\Coupon");
    }

    public function prizes()
    {
        return $this->hasMany("App\Models\UserPrize");
    }

    public function actions()
    {
        return $this->hasMany("App\Models\UserAction");
    }

    public function admin()
    {
        return $this->belongsTo("App\Models\AdminUser");
    }
    public function stars()
    {
        return $this->belongsToMany("App\Models\Product", "product_stars", "user_id", "product_id");
    }
    public function company()
    {
      return $this->belongsTo("App\Models\Company");
    }

    /**
     * 关注注册
     */
    public static function subRegister($message)
    {
        \Log::info($message);
    }

    public function sendMessage($msg)
    {
        $app = EasyWeChat::officialAccount();
        $app->customer_service->message($msg)->to($this->openid)->send();
    }
    
}
