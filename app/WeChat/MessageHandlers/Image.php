<?php

use App\Models\User;

class Image
{
    public function handle($message)
    {
        $user = User::where("openid", $message["FromUserName"])->get()->first();
        $msg = "你的用户【{$user->name}】给你发了一张<a href=\"{$message["PicUrl"]}\">图片</a>";
        $user->admin->sendMessage($msg);
        return new Text("您的消息已经转发给客服");
    }
}