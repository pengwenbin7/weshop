<?php

namespace App\WeChat;

use EasyWeChat\Kernel\Messages\Text;

class MessageHandler
{
    protected $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function run()
    {
        $msgType = strtolower($this->message["MsgType"]);
        $event = strtolower($this->message["Event"]) ?? null;
        $eventKey = strtolower($this->message["EventKey"]) ?? null;
        $str = $msgType;
        if ($event) {
            $str = "{$str}.{$event}";
            if ($eventKey) {
                $str = "{$str}.{$eventKey}";
            }
        }
        try {
            $cls = app()->make(config($str));
            return $cls->run($this->message);
        } catch (\ReflectionException $e) {
            // 默认消息
            // $str = "您可在此直接输入文字搜索产品，也可以发送图片和声音给客服";
            $str = "您可在此直接输入文字搜索产品，也可以发送图片给客服";
            return new Text($str);
        }
    }
}

/**
 * 消息示例
[2018-07-09 17:48:51] local.INFO: array (
  'ToUserName' => 'gh_a8ce0d11c766',
  'FromUserName' => 'obOoJwQa8TO57HLd8WHtuXP91CE8',
  'CreateTime' => '1531129731',
  'MsgType' => 'event',
  'Event' => 'unsubscribe',
  'EventKey' => NULL,
)  
[2018-07-09 17:49:02] local.INFO: array (
  'ToUserName' => 'gh_a8ce0d11c766',
  'FromUserName' => 'obOoJwQa8TO57HLd8WHtuXP91CE8',
  'CreateTime' => '1531129742',
  'MsgType' => 'event',
  'Event' => 'subscribe',
  'EventKey' => 'qrscene_A3abf34eb',
  'Ticket' => 'gQEG8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyWGtqYlFPSUdjOTExMDAwMDAwN0oAAgQ-L-1aAwQAAAAA',
)  
[2018-07-09 17:49:34] local.INFO: array (
  'ToUserName' => 'gh_a8ce0d11c766',
  'FromUserName' => 'obOoJwQa8TO57HLd8WHtuXP91CE8',
  'CreateTime' => '1531129774',
  'MsgType' => 'event',
  'Event' => 'CLICK',
  'EventKey' => 'share',
)  
[2018-07-09 17:50:11] local.INFO: array (
  'ToUserName' => 'gh_a8ce0d11c766',
  'FromUserName' => 'obOoJwQa8TO57HLd8WHtuXP91CE8',
  'CreateTime' => '1531129810',
  'MsgType' => 'event',
  'Event' => 'SCAN',
  'EventKey' => 'Ac22a0dae',
  'Ticket' => 'gQGk8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyYVU2X1I0SUdjOTExMDAwMGcwN0YAAgRWjRRbAwQAAAAA',
)  
*/