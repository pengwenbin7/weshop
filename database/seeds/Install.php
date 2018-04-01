<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Utils\RecommendCode;
use App\Models\AdminUser;

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
        $code = RecommendCode::generate(new AdminUser(), 1);
        DB::table("admin_users")->insert([
            "id" => 1,
            "name" => "admin",
            "password" => bcrypt("admin"),
            "rec_code" => $code,
            "created_at" => $now,
        ]);
        
        DB::table("locales")->insert([
            "id" => 1,
            "name" => "zh-CN",
            "currency" => "CNY",
            "full_name" => "中华人民共和国",
            "created_at" => $now,
        ]);
    }
}
