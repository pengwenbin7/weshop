<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Jobs\ShipmentPurchased;
use App\Jobs\ShipmentShipped;
use App\Models\Order;
use App\Models\User;
use App\Models\company;

class Shipment extends Model
{
    protected $fillable = [
        "order_id", "purchase",
        "status", "freight", "cost",
        "from_address", "to_address",
        "ship_no", "contact_name", "license_plate",
        "contact_phone", "expect_arrive",
    ];

    protected $dates = [
        "expect_arrive", "ship_time", "arrive",
    ];

    public function order()
    {
        return $this->belongsTo("App\Models\Order");
    }

    public function shipmentItems()
    {
        return $this->hasMany("App\Models\ShipmentItem");
    }

    public function purchased($cost)
    {
        $this->cost = $cost;
        $this->purchase = true;
        dispatch(new ShipmentPurchased($this));
        return $this->save();
    }

    public function shipped($freight)
    {
        if (!$this->purchase) {
            return false;
        }
        $this->freight = $freight;
        $this->ship_time = Carbon::now();
        $this->status = true;
        dispatch(new ShipmentShipped($this));
        return $this->save();
    }
    //获取企业名称
    public function compent($order)
    {
        $Order = Order::find($order);
        $User = User::find($Order->user_id);
        if (isset($User->company_id)) {
            $company = company::find($User->company_id);
            if (isset($company->name)) {
              return $company->name;
            }
        }
    }
    //获取订单号
    public function order_list($order)
    {
        $Order = Order::find($order);
        return $Order->no;
    }
}
