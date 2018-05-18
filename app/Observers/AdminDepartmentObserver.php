<?php

namespace App\Observers;

use App\Models\AdminUser as Admin;
use App\Models\Department;
use App\Models\AdminDepartment;
use App\Jobs\UpdateAdminPermission;

class AdminDepartmentObserver
{
    /**
     * 监听员工部门存储事件
     *
     * @param  AdminDepartment $adminDepartment
     * @return void
     */
    public function saved(AdminDepartment $adminDepartment)
    {
        /* 更新权限
         * 更新权限是耗时操作，且存在并发更新用户操作，
         * 所以需要用 Job 实现
         */
        $users = $adminDepartment->adminUsers;
        foreach ($users as $user) {
            UpdateAdminPermission::dispatch($user);
        }
    }
}