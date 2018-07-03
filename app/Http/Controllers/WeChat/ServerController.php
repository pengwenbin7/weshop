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
                $user = User::subRegister($openid);
            }
            $user = $users->first();
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
                    User::subRegister($message);
                    return new Text("感谢关注！");
                    break;
                //分享
                case "CLICK":
                    $url = "http://mp.weixin.qq.com/s?__biz=MzIzODY1MjUyNA==&mid=100000699&idx=1&sn=aed691ad9bae87df98f30d818d5b947f&chksm=69375eb85e40d7ae812971ce445dbe6a146ff824322e2e815dee9dd0002d2875b23bda67fc6b#rd";
                    $span = new SpreadQR;
                    $img = $span->orgcode(substr(md5(time()), 0, 8));
//                    $items = [
//                        new NewsItem([
//                            'title'       => "邀请好友至“太好买”下单，领取现金红包！",
//                            'description' => "详情进【链接】",
//                            'url'         => $url,
//                            'image'       => '',
//                        ]),
//                        new NewsItem([
//                            'title'       => "",
//                            'description' => "",
//                            'url'         => '',
//                            'image'       => $img,
//                        ]),
//                    ];
//                    $news = new News($items);
//                    return $news;
//                    $news1 = new NewsItem([
//                            'title'       => "邀请好友至“太好买”下单，领取现金红包！",
//                            'description' => "详情进【链接】",
//                            'url'         => $url,
//                            'image'       => '',
//                        ]);
//                    $news2 = new sendImage($img);
                    $image = new Image($img);
                    return new News($image);
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
