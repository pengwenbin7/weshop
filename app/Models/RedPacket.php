<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 红包类. 讲道理红包是 "red envelope",
 * don't care it.
 */
class RedPacket extends Model
{
    protected $fillable = [
        "mch_billno", "mcn_id", "wxappid",
        "send_name", "re_openid", "total_amount",
        "wishing", "client_ip", "act_name",
        "scene_id", "risk_info", "consume_mch_id",
    ];
}
