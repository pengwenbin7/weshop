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
        "id","title", "text_type", "result",
        "ending", "link", "user_type"
    ];
    public function products($type)
    {
        $span = [
                '10086' => "暂无",'2' => "星标客户",
                '102' => "下游客户",'105' => "同行及其他",
                '107' => "供应商",'108' => "未知可发",
                '109' => "调价消息推送",'100' => "马峰"
                ];
        return $span[$type];

    }
}
