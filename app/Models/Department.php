<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasPermissions;
use EasyWeChat;

/**
 * 部门类，不要在应用逻辑中直接操作此类，
 * 通过＂企业微信＂操作
 * 权限在 config/department.php 里
 */
class Department extends Authenticatable
{
    use HasPermissions;
    
    protected $fillable = [
        "id", "name", "parentid", "order",
    ];

    protected $guard_name = "admin";

    public function adminUsers()
    {
        return $this->belongsToMany("App\Models\AdminUser", "admin_departments", "department_id", "admin_id");
    }

    // 调用企业微信发送消息
    public function sendMessage($message)
    {
        $work = EasyWeChat::work();
        $work->messenger
            ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
            ->message($message)
            ->toParty($this->id)
            ->send();
    }
}
