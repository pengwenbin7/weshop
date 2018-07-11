<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Marketing extends Model
{
    //use SoftDeletes;
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
