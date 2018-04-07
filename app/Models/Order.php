<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 订单状态
    const ORDER_STATUS_WAIT = 0; // 待处理
    const ORDER_STATUS_DOING = 1; // 处理中
    const ORDER_STATUS_DONE = 2; // 完成
    const ORDER_STATUS_IDL = 3; // 无效
    // 付款状态
    const PAY_STATUS_WAIT = 0; // 待付款
    const PAY_STATUS_PART = 1; // 部分付款
    const PAY_STATUS_DONE = 2; // 完成
    const PAY_STATUS_REFUND = 3; // 退款
    // 发货状态
    const SHIP_STATUS_WAIT = 0;  // 待发货
    const SHIP_STATUS_PART = 1;  // 部分发货
    const SHIP_STATUS_DONE = 2;  // 发货完成
    const SHIP_STATUS_SURE = 3;  // 确认收货
    // 退货状态
    const REFUND_STATUS_NULL = 0;  // 未申请
    const REFUND_STATUS_ASK = 1;  // 申请退货
    const REFUND_STATUS_DOING = 2; // 等待退货
    const REFUDN_STATUS_DONE = 3;  // 已退货
    
    public function orderItems()
    {
        return $this->hasMany("App\Models\OrderItem");
    }

    public function shipments()
    {
        return $this->hasMany("App\Models\Shipment");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\ShopUser");
    }

    public function adminUser()
    {
        return $this->belongsTo("App\Models\AdminUser");
    }

    public function address()
    {
        return $this->belongsTo("App\Models\Address");
    }

    public function coupon()
    {
        return $this->belongsTo("App\Models\Coupon");
    }
    
    public function tax()
    {
        return $this->belgonsTo("App\Models\Tax");
    }
    
}
