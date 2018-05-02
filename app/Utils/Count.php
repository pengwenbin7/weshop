<?php

namespace App\Utils;

use App\Models\Address;
use App\Models\AddressDistance;
use App\Models\Storage;

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
            $distance = ceil(($res->data->route->paths)[0]->distance);
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
     * count freight
     * @param int $storage_id
     * @param int $weight - kg
     * @param int $distance - m
     */
    public static function freight($storage_id, $weight, $distance)
    {
        $storage = Storage::find($storage_id);
        $func = json_decode($storage->func);
        foreach ($func->area as $a) {
            if ($a->low  <= $weight && $weight < $a->up) {
                return $distance * $a->factor + $a->const;
            }
        }
        return $distance * $func->other->factor + $func->other->const;
    }
}