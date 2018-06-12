<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $dates = ["expire"];
    protected $fillable = [
        "user_id", "discount", "amount",
        "expire", "from_admin", "description",
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function fromAdmin()
    {
        return $this->belongsTo("App\Models\AdminUser", "from_admin");
    }
    
    // 判断用户此订单是否可以用此优惠券
    public function valid(User $user, Payment $payment)
    {
        if ($payment->pay >= $this->amount &&
            $this->expire->gt(Carbon::now()) &&
            $user == $this->user
        ) {
            return true;
        } else {
            return false;
        }
    }
}
