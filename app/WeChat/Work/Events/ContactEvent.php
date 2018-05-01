<?php

namespace App\WeChat\Work\Events;

use EasyWeChat;
use Log;

class ContactEvent extends Event
{
    public $app;
    
    public function __construct(array $msg)
    {
        parent::__construct($msg);
        $this->app = EasyWeChat::work();
    }

    /**
     * 通讯录修改
     * 因为 Create 用户时，微信也会发一条 Update 信息，
     * 而 Create 用户未完成时无法执行 Update 操作，
     * 所以把 Create 操作也放到 Update 里执行
     */
    public function handle()
    {
        $type = $this->msg["ChangeType"];
        $arr = explode("_", $type);
        $arr = array_map(function ($word) {
            return ucfirst($word);
        }, $arr);
        $cname = __NAMESPACE__ . "\\ChangeContacts\\" . implode("", $arr);
        if (class_exists($cname)) {
            (new $cname($this->msg))->handle();
        }
        return "success";
    }

}