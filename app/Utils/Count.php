<?php

namespace App\Utils;

use App\Models\Region;
use App\Models\RegionDistance;

class Count
{
    /**
     *
     * count freight
     * @param $fromCode 起点地区码
     * @param $toCode 终点地区码
     */
    public static function distance($fromCode, $toCode)
    {
        // 检查本地缓存
        $local = RegionDistance::where("from", "=", $fromCode)
               ->where("to", "=", $toCode)
               ->get();
        if (!$local->isEmpty()) {
            return $local->first()->distance;
        }
        
        $from = Region::find($fromCode);
        $to = Region::find($toCode);
        $origin = "{$from->lng},{$from->lat}";
        $destination = "{$to->lng},{$to->lat}";
        $url = "http://restapi.amap.com/v4/direction/truck?parameters" .
             "&origin={$origin}&destination={$destination}" .
             "&size=4" .
             "&key=" . env("LBS_AMAP_COM_KEY");
        $res = json_decode(file_get_contents($url));
        if ($res->errcode) {
            Log::error("{$res->errmsg}: {$res->errdetail}");
            return -1;
        } else {
            //　这里不需要很精确，取第一个即可
            $distance = ($res->data->route->paths)[0]->distance;
            // 写入本地缓存
            $rd = RegionDistance::create([
                "from" => $fromCode,
                "to" => $toCode,
                "distance" => $distance,
            ]);
            $rd = RegionDistance::create([
                "from" => $toCode,
                "to" => $fromCode,
                "distance" => $distance,
            ]);
            
            return $distance;
        }
    }
}