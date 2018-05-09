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
    const PAY_STATUS_AFTER = 4;  // 到付
    const PAY_STATUS_ERROR = 5; // 错误
    // 发货状态
    const SHIP_STATUS_WAIT = 0;  // 待发货
    const SHIP_STATUS_PART = 1;  // 部分发货
    const SHIP_STATUS_DONE = 2;  // 发货完成
    const SHIP_STATUS_SURE = 3;  // 确认收货
    // 退货状态
    const REFUND_STATUS_NULL = 0;  // 未申请
    const REFUND_STATUS_ASK = 1;  // 申请退货
    const REFUND_STATUS_DOING = 2; // 等待退货
    const REFUND_STATUS_DONE = 3;  // 已退货
    
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

    public function canRemove()
    {
        return true;
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
                "status" => 0,
                "from_address" => Address::find($storage_id)->getText(),
                "to_address" => $this->address->getText(),
            ]);
            ShipmentItem::create([
                "shipment_id" => $shipment->id,
                "product_name" => $item->product_name,
                "product_model" => $item->model,
                "brand_name" => $item->brand_name,
                "number" => $item->number,
                "packing_unit" => $item->packing_unit,
            ]);
        }
    }

}
