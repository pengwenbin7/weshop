<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    protected $fillable = [
        "order_id", "channel_id", "total",
        "tax", "freight", "coupon_discount",
        "share_discount", "pay_discount", "pay",
        "paid", "pay_time", "share_discount",
    ];

    public function getStartAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getExpireAttribute($value)
    {
	    return Carbon::parse($value);
    }

    public function coupon()
    {
        return $this->belongsTo("App\Models\Coupon");
    }

    public function order()
    {
        return $this->belongsTo("App\Models\Order");
    }

    public function channel()
    {
        return $this->belongsTo("App\Models\PayChannel", "channel_id");
    }
}
