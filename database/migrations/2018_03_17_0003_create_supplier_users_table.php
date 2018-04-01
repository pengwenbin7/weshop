<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string("wechat_openid", 100)->unique()->nullable();
            $table->string("name", 32)->unique();
            $table->string("phone", 16)->unique();
            $table->string("password", 100)->nullable();
            $table->string("area", 100)->nullable()->comment("主营区域");
            $table->string("license", 100)->nullable()->comment("营业执照");
            $table->unsignedInteger("address_id")->nullable();
            $table->text("description")->nullable();
            $table->unsignedDecimal("turnover", 10, 2)->default(0)->comment("营业额(亿元)");
            $table->string("site", 100)->nullable()->comment("供应商网站");
            $table->boolean("active")->default(false);
            $table->unsignedDecimal("price_up", 8, 2)->default(0)->comment("自动调价值");
            $table->unsignedInteger("admin_id")->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign("address_id")->references("id")->on("addresses")->onDelete("cascade");
            $table->foreign("admin_id")->references("id")->on("admin_users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_users');
    }
}
