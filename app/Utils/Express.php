<?php

namespace App\Utils;

use GuzzleHttp\Client;

class Express
{
    /**
     * 根据订单号查询
     */
    public function fetch($no)
    {
        $requestData= json_encode([
            "ShipperCode" => $this->fetchShipper($no),
            "LogisticCode" => $no,
        ]);
        $sign = $this->sign($requestData);
        $datas = [
            "form_params" => [
                "EBusinessID" => config("express.EBusinessID"),
                "RequestType" => config("express.RequestType.track"),
                "DataType" => config("express.DataType"),
                "RequestData" => urlencode($requestData),
                "DataSign" => $sign,
            ],
        ];
        
        $client = new Client();
        return json_decode($client->post(config("express.url"), $datas)
                           ->getBody()
                           ->getContents());
    }

    /**
     * 根据订单号查询快递公司
     */
    public function fetchShipper($no)
    {
        $requestData = json_encode([
            "LogisticCode" => $no,
        ]);
        $sign = $this->sign($requestData);
        $datas = [
            "form_params" => [
                "EBusinessID" => config("express.EBusinessID"),
                "RequestType" => config("express.RequestType.shipper"),
                "DataType" => config("express.DataType"),
                "RequestData" => urlencode($requestData),
                "DataSign" => $sign,
            ],
        ];
        $client = new Client();
        $res = $client->post(config("express.url"), $datas)
                           ->getBody()
                           ->getContents();
        $res = json_decode($res);
        if (count($res->Shippers)) {
            return $res->Shippers[0];
        } else {
            return null;
        }
    }

    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    private function sign($data)
    {
        $key = config("express.AppKey");
        return urlencode(base64_encode(md5($data . $key)));
    }
}
