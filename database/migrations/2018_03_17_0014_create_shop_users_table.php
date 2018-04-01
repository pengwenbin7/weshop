<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_users', function (Blueprint $table) {
            $table->increments("id");
            $table->string("openid", 100)->unique();
            $table->string("name", 32)->nullable();
            $table->string("phone", 32)->unique()->nullable();
            $table->string("password", 100)->nullable();
            $table->unsignedInteger("integral")->default(0)->comment("积分");
            $table->boolean("active")->default(true);
            $table->boolean("if_subscribe")->default(true);
            $table->unsignedInteger("subscribe_count")->default(1)->comment("第几次订阅");
            $table->string("rec_code", 100)->comment("推荐码")->unique();
            $table->string("rec_from", 100)->nullable()->comment("推荐来源");
            $table->unsignedInteger("share_count")->default(0)->comment("分享次数");
            $table->unsignedInteger("company_id")->nullable();
            $table->unsignedInteger("admin_id")->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign("admin_id")
                ->references("id")
                ->on("admin_users")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_users');
    }
}
