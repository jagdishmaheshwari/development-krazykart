<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('items', function (Blueprint $table) {
            $table->id('item_id');
            $table->unsignedBigInteger('fk_category_id');
            $table->unsignedBigInteger('fk_product_id');
            $table->unsignedBigInteger('fk_color_id');
            $table->unsignedBigInteger('fk_size_id');
            $table->unsignedInteger('mrp');
            $table->unsignedInteger('price');
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('priority')->nullable();
            $table->timestamps();

            $table->foreign('fk_category_id')->references('category_id')->on('categories')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('fk_product_id')->references('product_id')->on('products')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('fk_color_id')->references('color_id')->on('colors')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('fk_size_id')->references('size_id')->on('sizes')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
