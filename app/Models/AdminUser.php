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
        "userid", "openid", "mobile",
        "name", "english_name", "email",
        "enable", "status", "position",
        "isleader", "gender", "avatar",
        "hide_mobile", "rec_code", "qr_code",
    ];

    protected $hidden = [
        "remember_token",
    ];

    protected $guard_name = "admin";

    public function departments()
    {
        return $this->belongsToMany("App\Models\Department", "admin_departments", "admin_id", "department_id");
    }
}
