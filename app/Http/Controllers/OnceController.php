<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnceController extends Controller
{
    public function index($token)
    {
        return $token;
    }
}
