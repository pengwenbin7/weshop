<?php

namespace App\Utils;

use EasyWeChat;
use App\Models\RedPacket as Packet;

/**
 * 红包类，讲道理红包是 "red envelope",
 * don't care it.
 */
class RedPacket
{
    public static function send()
    {
        $payment = EasyWeChat::payment();
        $redPacket = $payment->redpack;
        
        $redpackData = [
            'mch_billno'   => 'xy123456',
            'send_name'    => '测试红包',
            're_openid'    => 'obOoJwQa8TO57HLd8WHtuXP91CE8',
            'total_num'    => 1,  //固定为1，可不传
            'total_amount' => 1,  //单位为分，不小于100
            'wishing'      => '祝福语',
            'act_name'     => '测试活动',
            'remark'       => '测试备注',
        ];

        $result = $redPacket->sendNormal($redpackData);
        return $result;
    }
}