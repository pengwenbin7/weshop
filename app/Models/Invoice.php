<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    
    // 发票状态
    // 未申请
    const WAIT = 0;
    // 已申请
    const REQUEST = 1;
    // 已开票
    const PRINT = 2;
    // 已寄出
    const SHIP = 3;

    protected $fillable = [
        "order_id", "admin_name", "status",
        "ship_no", "address_id",
    ];

    protected $dates = ["deleted_at"];
    
    public function order()
    {
        return $this->belongsTo("App\Models\Order");
    }

    public function address()
    {
        return $this->belongsTo("App\Models\Address");
    }
}
