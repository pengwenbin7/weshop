<?php

namespace App\WeChat\Work\Events\ChangeContacts;

use App\WeChat\Work\Events\ContactEvent;
use App\Models\AdminUser as Admin;
use App\Models\AdminDepartment;
use Log;

class UpdateUser extends ContactEvent
{
    public function __construct(array $msg)
    {
        parent::__construct($msg);
    }

    /**
     * 根据回调信息修改 admin_user
     * 因为新建和修改都在此完成，总是获取完整信息进行操作
     * @param void
     * @return void
     */
    public function handle()
    {
        /*
         * 根据 UserID 或 NewUerID 获取　AdminUser 对象
         * 及其信息
         */
        $userid = $this->msg["NewUserID"] ?? $this->msg["UserID"];
        $arr = $this->app->user->get($userid);
        if ($arr["errcode"]) {
            Log::error($arr["errmsg"]);
            return "success";
        }
        $res = $this->app->user->userIdToOpenid($userid);
        $openid = $res["openid"];
        $fetch = Admin::where("openid", "=", $openid)->get();
        $admin = $fetch->isEmpty()?
               new Admin():
               $fetch->first();
        $fill = array_except($arr, [
            "department", "extattr", "order",
        ]);
        $fill["openid"] = $openid;
        $admin->fill($fill)->save();
        
        AdminDepartment::where("admin_id", "=", $admin->id)
            ->delete();
        foreach ($arr["department"] as $d) {
            AdminDepartment::create([
                "admin_id" => $admin->id,
                "department_id" => $d,
            ]);
        }
    }
}
