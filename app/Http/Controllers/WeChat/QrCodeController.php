<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;

class QrCodeController extends Controller
{
    private $app;
    public function __construct()
    {
        $this->app = EasyWeChat::officialAccount();
    }
    
    public function index()
    {
        $result = $this->app->qrcode->forever("user_0001");
        $url = $this->app->qrcode->url($result["ticket"]);
        $content = file_get_contents($url);
        header("Content-Type: image/jpeg");
        file_put_contents("php://output", $content);
    }
}
