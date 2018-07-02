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

class ServerController extends Controller
{
    public function serve()
    {
        $app = EasyWeChat::officialAccount();
        $app->server->push(function($message){
            $openid = $message["FromUserName"];
            $users = User::where("openid", "=", $openid)->get();
            if ($users->isEmpty()) {
                // register user
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
