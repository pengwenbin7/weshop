<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Utils\RecommendCode;
use App\Models\AdminUser;
use App\Models\Config;

class Install extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        
        DB::table("locales")->insert([
            "id" => 1,
            "name" => "zh-CN",
            "currency" => "CNY",
            "full_name" => "中华人民共和国",
            "created_at" => $now,
        ]);

        $func = [
            "area" => [
                ["low" => 0, "up" => 5000, "factor" => 0, "const" => 245,],
                ["low" => 5000, "up" => 30000, "factor" => 0.4 / 1000, "const" => 0,],
            ],
            "other" => [
                "factor" => 0, "const" => 0,
            ],
        ];
        Config::create([
            "key" => "storage.func",
            "value" => json_encode($func),
            "note" => "运费计算默认公式",
        ]);

        Config::create([
            "key" => "order.pay.online",
            "value" => "" . (24 * 60 * 60),
            "note" => "线上付款订单自动失效时间",
        ]);

        Config::create([
            "key" => "order.pay.offline",
            "value" => "" . (2 * 24 * 60 * 60),
            "note" => "线下付款订单自动失效时间",
        ]);
        
        Config::create([
            "key" => "order.ship.doing",
            "value" => "" . (12 * 60 * 60),
            "note" => "付款订单自动发货时间",
        ]);

        Config::create([
            "key" => "order.ship.done",
            "value" => "" . (7 * 24 * 60 * 60),
            "note" => "发货后自动确认收货时间",
        ]);
        
        Config::create([
            "key" => "order.refund.allow",
            "value" => "" . (12 * 60 * 60),
            "note" => "申请退货自动同意时间",
        ]);

            Config::create([
            "key" => "order.refund.done",
            "value" => "" . (7 * 24 * 60 * 60),
            "note" => "退货后自动确认时间",
        ]);

        DB::table("pay_channels")->insert([
            "name" => "offline",
        ]);

        DB::table("pay_channels")->insert([
            "name" => "wechat",
        ]);
        
    }
}
