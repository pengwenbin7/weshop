<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\Region;

class AddressObserver
{
    public function saving(Address $address)
    {
        // 检查city和city_adcode是否匹配
        $city = Region::where("adcode", "=", $address->city_adcode)
              ->first();
        if ($city->name == $address->city) {
            $address->city_center = $city->center;
        } else {
            throw new \Exception("The city and city_code doesn't match ({$city->name}: {$address->city})");
        }
    }
}