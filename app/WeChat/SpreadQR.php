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
        $f = "qr/{$code}.jpg";
        Storage::put($f, $content);
        return Storage::url($f);
    }

    public static function foreverMedia(string $code, $delete = true)
    {
        $app = EasyWeChat::officialAccount();
        // 获取　ticket
        $result = $app->qrcode->forever($code);
        // 由凭据换取二维码
        $url = $app->qrcode->url($result["ticket"]);
        $content = file_get_contents($url);
        // 本地保存二维码图片
        $f = "qr/{$code}.jpg";
        Storage::put($f, $content);
        $file = Storage::getDriver()->getAdapter()->getPathPrefix() . $f;
        // 上传到永久素材
        $up = $app->media->uploadImage($file);
        if ($delete) {
            // 删除本地图片
            Storage::delete($f);
        }
        return $up["media_id"];
    }

    /*
     * 获取二维码
     */
    public static function orgcode(string $code)
    {
        $app = EasyWeChat::officialAccount();
        $result = $app->qrcode->forever($code);
        $url = $app->qrcode->url($result["ticket"]);
        $content = file_get_contents($url);
        $f = "qr/{$code}.jpg";
        Storage::put($f, $content);
        return Storage::url($f);
    }

}