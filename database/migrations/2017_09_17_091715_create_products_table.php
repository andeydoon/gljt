<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('material_id');
            $table->string('name')->comment('名称');
            $table->string('describe')->nullable()->comment('描述');
            $table->decimal('price', 7, 2)->comment('单价');
            $table->string('unit', 20)->comment('单位');
            $table->mediumText('overview')->nullable()->comment('概述');
            $table->tinyInteger('status')->default(-1)->comment('状态');
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
        Schema::dropIfExists('products');
    }
}
