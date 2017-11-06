<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCustomSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_custom_schemes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('order_custom_id');
            $table->text('content')->nullable()->comment('内容');
            $table->text('items')->nullable()->comment('项目');
            $table->string('thickness')->nullable()->comment('厚度');
            $table->string('height')->nullable()->comment('高度');
            $table->string('width')->nullable()->comment('宽度');
            $table->text('pictures')->nullable()->comment('图片');
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
        Schema::dropIfExists('order_custom_schemes');
    }
}
