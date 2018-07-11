<?php

namespace App\Utils;

use App\Models\Address;
use App\Models\AddressDistance;
use App\Models\Storage;
use Log;

class Count
{
    /**
     *
     * count distance
     * @param $from 起始 address id
     * @param $to 终点 address id
     * @return int distance
     * 如果返回值为 -1 则说明至少存在一个信息不正确的地址
     */
    public static function distance($from, $to)
    {
        // 检查本地缓存
        $local = AddressDistance::where("from", "=", $from)
               ->where("to", "=", $to)
               ->get();
        if ($local->isNotEmpty()) {
            return $local->first()->distance;
        }

        $from = Address::find($from);
        $to = Address::find($to);
        
        // 存在至少一个地址没有正确的经纬度信息，不可计算
        if (!$from->countable || !$to->countable) {
            return -1;
        }
        
        $origin = "{$from->lng},{$from->lat}";
        $destination = "{$to->lng},{$to->lat}";
        $url = "http://restapi.amap.com/v3/direction/driving?parameters" .
             "&origin={$origin}&destination={$destination}" .
             "&key=" . env("LBS_AMAP_COM_KEY");
        $res = json_decode(file_get_contents($url));
        if (!$res->status) {
            Log::error($res->info);
            return -1;
        } else {
            //　这里不需要很精确，取第一个即可
            $distance = intval(($res->route->paths)[0]->distance);
            // 写入本地缓存
            AddressDistance::create([
                "from" => $from->id,
                "to" => $to->id,
                "distance" => $distance,
            ]);
            AddressDistance::create([
                "from" => $to->id,
                "to" => $from->id,
                "distance" => $distance,
            ]);
            
            return $distance;
        }
    }

    /**
     * count freight, 按百位四舍五入
     * @param int $storage_id
     * @param int $weight - kg
     * @param int $distance - m
     */
    public static function freight($storage_id, $weight, $distance)
    {
        $freight = 0;
        $storage = Storage::find($storage_id);
        $func = json_decode($storage->func);

        echo $distance.",,,,".$weight;
        exit;
        foreach ($func->area as $a) {
            if ($a->low  <= $weight && $weight < $a->up) {
                return round(($distance * $weight * $a->factor + $a->const) / 100) * 100;
            }
        }
        return round(($distance * $weight * $func->other->factor + $func->other->const) / 100) * 100;
    }
}