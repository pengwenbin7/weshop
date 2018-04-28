<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 部门人员类
 * 不要在应用逻辑中直接操作此类，
 * 在＂企业微信＂中操作
 */
class AdminDepartment extends Model
{
    protected $fillable = [
        "admin_id", "department_id",
    ];

    public function adminUsers()
    {
        return $this->hasMany("App\Models\AdminUser", "id", "admin_id");
    }

    public function departments()
    {
        return $this->hasMany("App\Models\Department", "id", "department_id");
    }
}
