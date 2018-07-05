<?php

namespace App\WeChat;

class MessageHandler
{
    protected $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        $cls = $this->message["MsgType"];
    }
}