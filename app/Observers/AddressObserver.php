<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\Region;
use Log;

class AddressObserver
{
    /**
     * 监听地址创建事件
     * 自动为每个地址加上经纬度的信息
     *
     * @param  Address $address
     * @return void
     */
    public function creating(Address $address)
    {        
        $code = $address->code;
        $fetch = Region::where("id", "=", $code)->get();
        // 处理行政划分已有的地址
        if ($fetch->isNotEmpty()) {
            $region = $fetch->first();
            $address->lat = $region->lat;
            $address->lng = $region->lng;
        } else {
            // 处理行政划分里面没有的地址
            $addr = $address->province . $address->city .
                  $address->district . $address->detail;
            $uri = sprintf("%s?key=%s&address=%s",
                           config("region.address_to_code"),
                           config("region.key"),
                           $addr);
            $res = json_decode(file_get_contents($uri));
            // lat, lng 为空则说明这是一个无法计算的地址
            if ($res->status == 0) {
                $address->lat = $res->result->location->lat;
                $address->lng = $res->result->location->lng;
            } else {
                $address->countable = false;
            }
        }
    }
}