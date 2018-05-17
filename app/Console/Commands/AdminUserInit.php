<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use EasyWeChat;
use App\Models\AdminUser as Admin;
use App\models\Department;
use App\Models\AdminDepartment;
use DB;
use Spatie\Permission\Models\Permission;

class AdminUserInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminuser:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial employee from work-wechat';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirm("该命令会重置数据且不可恢复，你确定要继续吗？")) {
            echo "bye bye\n";
            exit;
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('departments')->truncate();
        DB::table('admin_users')->truncate();
        DB::table("admin_departments")->truncate();
        DB::table("model_has_permissions")->truncate();
        DB::table("model_has_roles")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 创建权限
        $all = [];
        $permissions = config("department.permission");
        foreach ($permissions as $ps) {
            foreach ($ps as $p) {
                $all[] = $p;
            }
        }
        $all = array_unique($all);
        foreach ($all as $i) {
            Permission::firstOrCreate(["name" => $i, "guard_name" => "admin"]);
        }
        
        // 获取部门
        $work = EasyWeChat::work();
        $list = $work->department->list();
        if ($list["errcode"] != 0) {
            die($list["errmsg"]);
        }
        $departments = $list["department"];
        // 部门授权
        foreach ($departments as $i) {
            $d = Department::create($i);
            $ps = $permissions[$d->id];
            // 获取部门成员
            $list = $work->user->getDetailedDepartmentUsers($d->id);
            if ($list["errcode"] != 0) {
                die($list["errmsg"]);
            }
            $admins = $list["userlist"];
            foreach ($admins as $a) {
                // 持久化内部人员
                $openid = $work->user->userIdToOpenid($a["userid"]);
                // 跳过未关注的员工
                if ($openid["errcode"] != 0) {
                    echo $openid["errmsg"] . "\n";
                } else {
                    $admin = Admin::firstOrCreate([
                        "userid" => $a["userid"],
                        "openid" => $openid["openid"],
                        "mobile" => $a["mobile"],
                        "name" => $a["name"],
                        "english_name" => $a["english_name"] ?? null,
                        "email" => $a["email"] ?? null,
                        "enable" => $a["enable"] ?? 1,
                        "status" => $a["status"],
                        "position" => $a["position"] ?? null,
                        "isleader" => $a["isleader"],
                        "gender" => $a["gender"],
                        "avatar" => $a["avatar"] ?? null,
                        "hide_mobile" => $a["hide_mobile"] ?? null,
                        "qr_code" => $a["qr_code"] ?? null,
                    ]);
                
                    /**
                     * 持久化人员所在部门
                     * 在此操作之后，在监视器里面更新人员权限
                     */
                    foreach ($a["department"] as $k => $v) {
                        AdminDepartment::firstOrCreate([
                            "admin_id" => $admin->id,
                            "department_id" => $d->id,
                        ]);
                    }
                }
            }
        }
    }
}
