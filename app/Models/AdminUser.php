<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use EasyWeChat;

/**
 * AdminUser　类，这个类名应该是　employe, 找个简单的单词 -_-
 * 字段参考：　https://work.weixin.qq.com/api/doc#10063
 * 不要在应用逻辑中直接操作此类，通过＂企业微信＂进行操作
 * 权限在 config/department.php 里
 */
class AdminUser extends Authenticatable
{
    //use HasPermissions;
    use HasRoles;
    
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

    public function users()
    {
        return $this->hasMany("App\Models\User", "admin_id");
    }

    public function moveUserTo(AdminUser $to)
    {
        $users = $this->users;
        $total = 0;
        $success = 0;
        foreach ($users as $user) {
            $user->admin_id = $to->id;
            $success += $user->save();
            $total++;
        }
        return [
            "total" => $total,
            "success" => $success,
        ];
    }

    // 调用企业微信发送消息
    public function sendMessage($message)
    {
        $work = EasyWeChat::work();
        $work->messenger
            ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
            ->message($message)
            ->toUser($this->userid)
            ->send();
    }
}
