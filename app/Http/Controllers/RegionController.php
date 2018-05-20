<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function children(Region $region = null)
    {
        $region = $region ?? Region::find(Region::CHINA_ID);
        return $region->children();
    }
}
