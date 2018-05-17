<?php

namespace App\WeChat;

use EasyWeChat;
use Storage;

/**
 * 公众号推广二维码
 */
class SpreadQR
{
    /**
     * 生成图片
     * @param $code 参数
     */
    public static function forever(string $code)
    {
        $app = EasyWeChat::officialAccount();
        $result = $app->qrcode->forever($code);
        $url = $app->qrcode->url($result["ticket"]);
        $content = file_get_contents($url);
        $f = "qr/" . time() . str_random(4) . ".jpg";
        Storage::put($f, $content);
        return Storage::url($f);
    }
}