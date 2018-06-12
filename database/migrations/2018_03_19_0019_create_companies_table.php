<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 100)->nullable();
            $table->string("address", 100)->nullable();
            $table->string("company_tel", 16)->nullable();
            $table->string("contact_name", 16)->nullable();
            $table->string("contact_phone", 16)->nullable();
            $table->string("license", 500)->comment("营业执照");
            $table->unsignedTinyInteger("status")->default(0)
                ->comment('审核状态:0未提交, 1资料已经提交审核中, 2审核不通过, 3审核通过');
            $table->string("code", 255)->comment("邀请码");
            $table->unsignedInteger("admin_id")->nullable()->comment("负责人");
            $table->unsignedInteger("creator");
            $table->timestamps();
            $table->foreign("admin_id")->references("id")
                ->on("admin_users")->onDelete("set null");
            $table->foreign("creator")->references("id")->on("users");
        });
        
        Schema::table("users", function (Blueprint $table) {
            $table->foreign("company_id")->references("id")->on("companies");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
