<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Utils\RecommendCode;
use App\Models\AdminUser;
use Spatie\Permission\Models\Permission;

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
        
        Permission::create(["name" => "user"]);
        Permission::create(["name" => "order"]);
        Permission::create(["name" => "pay"]);
        Permission::create(["name" => "ship"]);
        Permission::create(["name" => "system"]);
        
        $admin = AdminUser::create([
            "name" => "admin",
            "password" => bcrypt("admin"),
            "rec_code" => "x",
        ]);

        $admin->givePermissionTo([
            "user", "order", "pay",
            "ship", "system",
        ]);
        
        DB::table("locales")->insert([
            "id" => 1,
            "name" => "zh-CN",
            "currency" => "CNY",
            "full_name" => "中华人民共和国",
            "created_at" => $now,
        ]);

        DB::table("configs")->insert([
            "key" => "order.pay.online",
            "value" => "" . (24 * 60 * 60),
            "note" => "线上付款订单自动失效时间",
        ]);

        DB::table("configs")->insert([
            "key" => "order.pay.offline",
            "value" => "" . (2 * 24 * 60 * 60),
            "note" => "线下付款订单自动失效时间",
        ]);
        
        DB::table("configs")->insert([
            "key" => "order.ship.doing",
            "value" => "" . (12 * 60 * 60),
            "note" => "付款订单自动发货时间",
        ]);

        DB::table("configs")->insert([
            "key" => "order.ship.done",
            "value" => "" . (7 * 24 * 60 * 60),
            "note" => "发货后自动确认收货时间",
        ]);
        
        DB::table("configs")->insert([
            "key" => "order.refund.allow",
            "value" => "" . (12 * 60 * 60),
            "note" => "申请退货自动同意时间",
        ]);

        DB::table("configs")->insert([
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
