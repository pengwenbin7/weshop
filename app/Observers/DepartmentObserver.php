<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver
{
    /**
     * 监听部门创建的事件
     *
     * @param  Department $department
     * @return void
     */
    public function created(Department $department)
    {
        $permissions = config("department.permission.{$department->id}");
        foreach ($permissions as $p) {
            $department->givePermissionTo($p);
        }
    }
}