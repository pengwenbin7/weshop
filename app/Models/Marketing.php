<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'marketing';
    protected $fillable = [
        "title", "text_type", "result",
        "ending", "link", "user_type"
    ];
    public function products()
    {

//        return ;
    }
}
