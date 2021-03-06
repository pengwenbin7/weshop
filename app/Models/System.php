<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'system';
    protected $fillable = [
        "setup", "setup_id", "status",
    ];
}
