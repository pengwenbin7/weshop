<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Address;
use App\Models\Region;
use App\Models\UserAddress as UserAddress;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = new Address();
        $address->fill([
            "contact_name" => $request->userName,
            "contact_tel" => $request->telNumber,
            "province" => $request->provinceName,
            "city" => $request->cityName,
            "district" => $request->countryName,
            "code" => $request->nationalCode,
            "detail" => $request->detailInfo,
        ]);
        $res = $address->save();
        if ($res) {
            return ["address_id" => $address->id];
        } else {
            return ["err" => "保存地址失败"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();
    }
}
