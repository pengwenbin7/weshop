<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use EasyWeChat;
use App\WeChat\SpreadQR;
use App\Models\AdminUser as Admin;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "openid", "name", "phone",
        "password", "rec_code", "rec_from",
        "is_subscribe", "headimgurl", "subscribe_time",
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

    public function lastAddress()
    {
        return $this->belongsTo("App\Models\Address", "last_address");
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
     * info format: [
         "subscribe" => 1,
         "openid" => "obOoJxxx",
         "nickname" => "知足",
         "sex" => 2,
         "language" => "zh_CN",
         "city" => "宁波",
         "province" => "浙江",
         "country" => "中国",
         "headimgurl" => "http://thOh/132",
         "subscribe_time" => 1530161190,
         "remark" => "",
         "groupid" => 108,
         "tagid_list" => [
             108,
         ],
         "subscribe_scene" => "ADD_SCENE_QR_CODE",
         "qr_scene" => 0,
         "qr_scene_str" => "Aa25b31c1",
     ]
     */
    public static function subRegister($openId, $from)
    {
        $app = EasyWeChat::officialAccount();
        $user = $app->user->get($openId);
        return static::create([
            "openid" => $openId,
            "is_subscribe" => $user["subscribe"],
            "name" => $user["nickname"],
            "headimgurl" => $user["headimgurl"],
            "subscribe_time" => $user["subscribe_time"],
            "rec_from" => $from ?? $user["qr_scene_str"],
        ]);
    }

    /**
     * 网页注册
     */
    public static function webRegister($user, $from)
    {
        $app = EasyWeChat::officialAccount();
        // 判断是否关注
        $info = $app->user->get($user->getId());
        $info["subscribe"];
        return static::create([
            "openid" => $user->getId(),
            "is_subscribe" => $info["subscribe"],
            "name" => $user->getName(),
            "headimgurl" => $user->getAvatar(),
            "subscribe_time" => $info["subscribe_time"] ?? null,
            "rec_from" => $from,
        ]);
    }

    public function sendMessage($msg)
    {
        $app = EasyWeChat::officialAccount();
        $app->customer_service->message($msg)->to($this->openid)->send();
    }

    // 生成唯一推广码
    public function generateCode()
    {
        return dechex(sprintf("%u", crc32($this->id)));
    }
    
    // 确定管理员 id
    public function generateAdmin()
    {
        $from = $this->rec_from;
        // 有人推广
        if ($from) {
            // 来自业务员的推广
            if ("A" == $from[0]) {
                $admins = Admin::where("rec_code", "=", $from)->get();
                // 此业务员已离职
                if ($admins->isEmpty()) {
                    $admin = Admin::permission("cs")->get()->random();
                } else {
                    $admin = $admins->first();
                }
            } else { // 来自用户的推广
                $us = User::where("rec_code", "=", $from)->get();
                if ($us->isEmpty()) { // 不存在的推广码
                    $admin = Admin::permission("cs")->get()->random();
                } else {
                    $u = $us->first();
                    $admin = $u->admin;
                }
            }
        } else {
            // 搜索关注的用户，随机分配一个
            $admin = Admin::permission("cs")->get()->random();
        }
        
        return $admin;
    }
    
    public function getShareImg()
    {
        if ($this->share_img) {
            return $this->share_img;
        } else {
            $img = $this->generateShareImg();
            $this->share_img = img;
            $this->save();
            return $img;
        }
    }
    
    /**
     * 生成分享二维码
     */
    public function generateShareImg()
    {
        if (!$this->rec_code) {
            $this->rec_code = $this->generateCode();
        }
        $code = $this->rec_code;
        return SpreadQR::foreverMedia($code);
    }
}
