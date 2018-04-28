<?php

namespace App\Observers;

use App\Models\AdminUser as Admin;
use App\Models\Department;
use App\Models\AdminDepartment;

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
        
    }
}