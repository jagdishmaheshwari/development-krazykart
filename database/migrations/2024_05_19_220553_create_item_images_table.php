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
        Schema::create('item_images', function (Blueprint $table) {
            $table->id('image_id');
            $table->unsignedBigInteger('fk_item_id');
            $table->string('url');
            $table->unsignedInteger('priority')->nullable();
            $table->timestamp('created_at');
            $table->foreign('fk_item_id')->references('item_id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
