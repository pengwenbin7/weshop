<?php

namespace App\WeChat\MessageHandlers;

interface HandlerInterface
{
    public function run(array $message);
}