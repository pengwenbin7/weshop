<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * 经纬度已实现自动写入
     */
    protected $fillable = [
        "contact_name", "contact_tel", "country",
        "province", "city", "district",
        "detail", "code",
    ];

    /**
     * 地址文本化
     */
    public function __toString()
    {
        return $this->province . $this->city .
                              $this->district . $this->detail;
    }
}
