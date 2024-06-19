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
         Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('fk_category_id');
            $table->foreign('fk_category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->string('product_code', 50);
            $table->string('product_name', 100);
            $table->text('p_description')->nullable();
            $table->string('p_keywords', 255)->nullable();
            $table->text('html')->nullable();
            $table->char('gender', 2);
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('priority')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('fk_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
