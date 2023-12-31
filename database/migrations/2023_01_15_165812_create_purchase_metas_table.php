<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_metas', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id');
            $table->string('category_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->string('unit_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_metas');
    }
};
