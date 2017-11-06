<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCustomSchemeDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_custom_scheme_drafts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('order_custom_id');
            $table->text('content')->nullable()->comment('内容');
            $table->text('parameters')->nullable()->comment('参数');
            $table->string('thickness')->nullable()->comment('厚度');
            $table->string('height')->nullable()->comment('高度');
            $table->string('width')->nullable()->comment('宽度');
            $table->text('pictures')->nullable()->comment('图片');
            $table->decimal('total', 8, 2)->nullable()->comment('金额');
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
        Schema::dropIfExists('order_custom_scheme_drafts');
    }
}
