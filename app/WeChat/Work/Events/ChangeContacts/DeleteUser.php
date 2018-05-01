<?php

namespace App\WeChat\Work\Events\ChangeContacts;

use App\WeChat\Work\Events\ContactEvent;
use App\Models\AdminUser as Admin;
use App\Models\AdminDepartment;
use Log;

class DeleteUser extends ContactEvent
{
    public function __construct(array $msg)
    {
        parent::__construct($msg);
    }

    /**
     * 根据回调信息删除 admin_user
     * @param void
     * @return void
     */
    public function handle()
    {
        // 根据 UserID 获取　openid
        $delete = Admin::where("userid", "=", $this->msg["UserID"])
                ->delete();
        if ($delte) {
            Log::info("delete user " . $arr["UserID"]);
        }
    }
}
