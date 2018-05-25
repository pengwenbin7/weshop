<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolController extends Controller
{
    /**
     * count two address's distance from address id
     */
    public function distance($from, $to)
    {
        return App\Utils\Count::distance($from, $to);
    }
}
