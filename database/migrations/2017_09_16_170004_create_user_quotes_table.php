<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('province_id')->default(0);
            $table->unsignedInteger('city_id')->default(0);
            $table->unsignedInteger('district_id')->default(0);
            $table->string('thickness')->nullable()->comment('厚度');
            $table->string('height')->nullable()->comment('高度');
            $table->string('width')->nullable()->comment('宽度');
            $table->string('phone', 50);
            $table->unsignedTinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_quotes');
    }
}
