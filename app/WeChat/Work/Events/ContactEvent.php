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