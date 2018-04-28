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
     * @param void
     * @return void
     */
    public function handle()
    {
        $msg = $this->msg;
        $app = $this->app;

        // 去除无关信息
        $arr = array_except($msg, [
            'ToUserName', 'FromUserName',
            'CreateTime', 'MsgType', 'Event',
            'ChangeType',
        ]);

        // 根据 UserID 或 NewUerID 获取　AdminUser
        if (array_key_exists("NewUserId", $arr)) {
            $openid = $app->user->userIdToOpenid($arr["NewUserID"]);
            $admin = Admin::where("openid", "=", $openid)->first();
        } else {
            $admin = Admin::where("userid", "=", $arr["UserID"])->first();
        }

        // 判断是否进行部门修改操作
        if (array_key_exists("Department", $arr)) {
            $ds = explode(",", $arr["Department"]);
            AdminDepartment::where("admin_id", "=", $admin->id)
                ->delete();
            foreach ($ds as $d) {
                AdminDepartment::create([
                    "admin_id" => $admin->id,
                    "department_id" => $d,
                ]);
            }
        }

        // 修改字段
        $attrs = $admin->attributesToArray();
        foreach ($arr as $k => $v) {
            $key = strtolower($k);
            if (array_key_exists($key, $attrs)) {
                $admin->$key = $v;
            }
        }
        
        if (!$admin->save()) {
            Log::error("通讯录更新回调出错");
            Log::info($msg);
            Log::info($admin);
        }
    }
}
