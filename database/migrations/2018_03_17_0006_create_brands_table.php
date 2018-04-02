<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->integer('id');
            $table->string("name", 32)->unique();
            $table->string("logo", 100)->nullable();
            $table->unsignedInteger("primary_category_id")->nullable();
            $table->smallInteger("sort_order")->unsigned()->default(100);
            $table->boolean("active")->default(1);
            $table->unsignedTinyInteger("locale_id");
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("primary_category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreign("locale_id")->references("id")->on("locales");
            $table->primary(["id", "locale_id"]);
        });
        
        Schema::table("brands", function (Blueprint $table) {
            $table->integer("id", true, true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
