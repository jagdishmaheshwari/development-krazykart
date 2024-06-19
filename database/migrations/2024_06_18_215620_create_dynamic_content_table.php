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
        Schema::create('dynamic_content', function (Blueprint $table) {
            $table->id('dynamic_content_id');
            $table->string('page_url')->nullable();
            $table->enum('type', ['collection', 'other']);
            $table->unsignedBigInteger('fk_collection_id');
            $table->unsignedInteger('priority')->nullable();
            $table->timestamps();

            $table->foreign('fk_collection_id')->references('collection_id')->on('collections')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_content');
    }
};
