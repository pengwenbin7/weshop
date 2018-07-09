<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Voice;
use App\Models\User;
use App\WeChat\SpreadQR;
use EasyWeChat\Kernel\Messages\Image;

class ServerController extends Controller
{
    public function serve()
    {
        $app = EasyWeChat::officialAccount();
        $app->server->push(function ($message) {
            $openid = $message["FromUserName"];
            $users = User::where("openid", "=", $openid)->get();
            if ($users->isEmpty()) {
                $from = null;
                if ($message["MsgType"] == "event" && $message["Event"] == "subscribe") {
                    $key = $message["EventKey"];
                    if ($key && starts_with($key, "qrscene_")) {
                        $from = str_after($key, "_");
                    } 
                }
                $user = User::subRegister($openid, $from);
            } else {
                $user = $users->first();
            }
            switch ($message["MsgType"]) {
            case "text":
                $url = route("wechat.search", ["keyword" => $message['Content']]);
                $items = [
                    new NewsItem([
                        'title'       => "搜索结果-太好买",
                        'description' => "点击查看搜索结果",
                        'url'         => $url,
                        'image'       => ''//asset("assets/img/search.jpg"),
                    ]),
                ];
                $news = new News($items);
                return $news;
                break;
            case "event":
                switch ($message["Event"]) {
                case "subscribe":
//                    return new Text("太好买2.0版正式上线！众多功能等您解锁！");
//                    break;
                        $items = [
                            new NewsItem([
                                'title'       => "太好买2.0版正式上线！众多功能等您解锁！",
                                'description' => "",
                                'url'         => "https://mp.weixin.qq.com/s/pHrUHED79n8uwDN6n4UvPA",
                                'image'       => 'asset("assets/img/search.jpg")',
                            ]),
                        ];
                        $news = new News($items);
                        return $news;
                //分享
                case "CLICK":
                    $url = "http://mp.weixin.qq.com/s?__biz=MzIzODY1MjUyNA==&mid=100000699&idx=1&sn=aed691ad9bae87df98f30d818d5b947f&chksm=69375eb85e40d7ae812971ce445dbe6a146ff824322e2e815dee9dd0002d2875b23bda67fc6b#rd";
                    $items = [
                        new NewsItem([
                            'title'       => "分享下方二维码，邀请好友下单领取现金奖励！",
                            'description' => "点击查看详情→→→",
                            'url'         => $url,
                            'image'       => '',
                        ]),
                    ];
                    $user->sendMessage(new News($items));
                    $user->sendMessage(new Image($user->getShareImg()));
                    return "success";
                    break;
                }
                break;

            case "image":
                $msg = "你的用户【{$user->name}】给你发了一张<a href=\"{$message["PicUrl"]}\">图片</a>";
                $user->admin->sendMessage($msg);
                return new Text("您的消息已经转发给客服");
                break;
            case "voice":
                $voice = new Voice($message["MediaId"]);
                $user->admin->sendMessage($voice);
                return new Text("您的消息已经转发给客服");
                break;
            default:
                return new Text("您可在此直接输入文字搜索产品，也可以发送图片和声音给客服");
                break;
            }
        });
        return $app->server->serve();
    }


}
