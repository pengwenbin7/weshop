<?php

namespace App\WeChat\Work\Events;

abstract class Event
{
    public $msg;
    public function __construct(array $message)
    {
        $this->msg = $message;
    }
    
    abstract public function handle();
}