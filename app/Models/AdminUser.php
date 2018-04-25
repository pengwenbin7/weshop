<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasPermissions;

/**
 * AdminUser　类，这个类名应该是　employe, 找个简单的单词 -_-
 * 字段参考：　https://work.weixin.qq.com/api/doc#10063
 * 不要在应用逻辑中直接操作此类，通过＂企业微信＂进行操作
 * 权限在 config/department.php 里
 */
class AdminUser extends Authenticatable
{
    use HasPermissions;
    
    protected $fillable = [
        "userid", "mobile", "name", "email",
        "status", "enable", "isleader",
        "gender", "avatar", "rec_code",
        "openid",
    ];

    protected $hidden = [
        "remember_token",
    ];

    protected $guard_name = "admin";
}
