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
            $table->string("name", 100);
            $table->string("oper_name", 100)->comment("法人");
            $table->string("code", 32)->comment("信用代码");
            $table->unsignedInteger("admin_id")->nullable()->comment("负责人");
            $table->timestamps();
            $table->foreign("admin_id")->references("id")
                ->on("admin_users")->onDelete("set null");
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
