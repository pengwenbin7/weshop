<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedPacket extends Model
{
    protected $fillable = [
        "mch_billno", "mcn_id", "wxappid",
        "send_name", "re_openid", "total_amount",
        "wishing", "client_ip", "act_name",
        "scene_id", "risk_info", "consume_mch_id",
    ];
}
