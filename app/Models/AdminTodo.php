<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 待实现的功能
 */
class AdminTodo extends Model
{
    protected $fillable = [
        "admin_id", "url", "note",
    ];

    public function admin()
    {
        return $this->belongsTo("App\Models\AdminUser", "admin_id");
    }
}
