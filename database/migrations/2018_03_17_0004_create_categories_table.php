<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id');
            $table->string("name", 100)->unique();
            $table->unsignedTinyInteger("locale_id")->default(1);
            $table->string("parent_id")->default(0);
            $table->smallInteger("sort_order")->default(1000);
            $table->text("description")->nullable();
            $table->timestamps();
            $table->primary(["id", "locale_id"]);
            $table->foreign("locale_id")->references("id")->on("locales");
        });

        Schema::table("categories", function (Blueprint $table) {
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
        Schema::dropIfExists('categories');
    }
}
