<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Count;
use App\Models\Storage;
use App\Models\Shipment;
use App\Models\Payment;
use App\Models\ShipmentItem;
use Log;

class Order extends Model
{
    // 付款状态
    const PAY_STATUS_WAIT = 0; // 待付款
    const PAY_STATUS_PART = 1; // 部分付款
    const PAY_STATUS_DONE = 2; // 完成    
    const PAY_STATUS_REFUND = 3; // 退款
    const PAY_STATUS_AFTER = 4;  // 到付
    const PAY_STATUS_ERROR = 5; // 错误
    // 退货状态
    const REFUND_STATUS_NULL = 0;  // 未申请
    const REFUND_STATUS_ASK = 1;  // 申请退货
    const REFUND_STATUS_ALLOW = 2; // 允许退货
    const REFUND_STATUS_REJECT = 3;  // 拒绝退货
    const REFUND_STATUS_DONE = 4;  // 已退货
    
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
        return $this->belongsTo("App\Models\User");
    }

    public function adminUser()
    {
        return $this->belongsTo("App\Models\AdminUser", "admin_id");
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

    public function payment()
    {
        return $this->hasOne("App\Models\Payment");
    }

    public function invoice()
    {
        return $this->hasOne("App\Models\Invoice");
    }

    public function canRemove()
    {
        return $this->active == 0;
    }

    /**
     * 订单状态 + 付款状态 + 发货状态
     */
    public function userStatus()
    {
        // 活动状态
        $activeString = $this->active ? "正常" : "失效";
        $status["active"] = [
            "status" => $this->active,
            "detail" => $activeString,
        ];
        
        // 付款状态
        switch ($this->payment_status) {
        case $this::PAY_STATUS_WAIT:
            $payString = "未付款";
            break;
        case $this::PAY_STATUS_PART:
            $payString = "部分付款";
            break;
        case $this::PAY_STATUS_DONE:
            $payString = "完成";
            break;
        case $this::PAY_STATUS_REFUND:
            $payString = "退款";
            break;
        case $this::PAY_STATUS_AFTER:
            $payString = "到付";
            break;
        case $this::PAY_STATUS_ERROR:
            $payString = "错误";
            break;
        default:
            $payString = "未知";
            break;
        }
        $status["pay"] = [
            "status" => $this->payment_status,
            "detail" => $payString,
        ];

        $shipments = $this->shipments;
        $shipped = 0;
        $purchased = 0;
        $total = 0;
        foreach ($shipments as $s) {
            $purchased += $s->purchase;
            $shipped += $s->status;
            $total++;
        }
        
        if (0 == $purchased) {
            $status["purchase"] = [
                "status" => 0,
                "detail" => "未采购",
            ];
        } elseif ($purchased > 0 && $purchased < $total) {
            $status["purchase"] = [
                "status" => 1,
                "detail" => "部分采购",
            ];            
        } elseif ($purchased == $total) {
            $status["purchase"] = [
                "status" => 2,
                "detail" => "完成采购",
            ];            
        } else {
            $status["ship"] = [
                "status" => -1,
                "detail" => "未知",
            ];            
        }
        
        if (0 == $shipped) {
            $status["ship"] = [
                "status" => 0,
                "detail" => "未发货",
            ];
        } elseif ($shipped > 0 && $shipped < $total) {
            $status["ship"] = [
                "status" => 1,
                "detail" => "部分发货",
            ];            
        } elseif ($shipped == $total) {
            $status["ship"] = [
                "status" => 2,
                "detail" => "已发货",
            ];            
        } else {
            $status["ship"] = [
                "status" => -1,
                "detail" => "未知",
            ];            
        }
        
        return $status;
    }

    /**
     * 运费计算
     * 当包含计量单位不为 kg 的物品时，返回 -1
     */
    public function countFreight()
    {
        $total = 0;
        // item 按仓库分组，对于计量单位不为"kg"的产品，返回 -1
        $items = $this->orderItems;
        $storages = [];
        foreach ($items as $item) {
            $product = $item->product;
            if (strtolower($product->measure_unit) != "kg") {
                return -1;
            }
            if (in_array($product->storage->id, $storages)) {
                $storages[$product->storage->id] += $product->count * $item->number;
            } else {
                $storages[$product->storage->id] = $product->count * $item->number;
            }
        }
        
        // 分组计算运费
        foreach ($storages as $storage_id => $weight) {
            $storage = Storage::with("address")->find($storage_id);
            $distance = Count::distance($this->address->id, $storage->address->id);
            $total += Count::freight($storage_id, $weight, $distance);
        }
        
        return $total;
    }

    /**
     * 生成该订单的未发货的发货单
     * 考虑到一次购买多个的情况不常见，使用 N + 1 查询
     */
    public function createShipments()
    {
        // 按仓库分组
        $items = [];
        foreach ($this->orderItems as $item) {
            $items[$item->storage_id][] = $item;
        }
        foreach ($items as $storage_id => $item) {
            $shipment = Shipment::firstOrCreate([
                "order_id" => $this->id,
                "purchase" => 0,
                "status" => 0,
                "from_address" => Address::find($storage_id)->getText(),
                "to_address" => $this->address->getText(),
            ]);
            foreach ($item as $i) {
                ShipmentItem::create([
                    "shipment_id" => $shipment->id,
                    "product_id" => $i->product_id,
                    "number" => $i->number,
                    "price" => $i->price,
                    "storage_id" => $i->storage_id,
                    "product_name" => $i->product_name,
                    "model" => $i->model,
                    "brand_name" => $i->brand_name,
                    "packing_unit" => $i->packing_unit,
                ]);
            }
        }
    }

}
