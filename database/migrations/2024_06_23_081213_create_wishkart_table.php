<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishkartTable extends Migration
{
    public function up()
    {
        Schema::create('wishkart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_user_id');
            $table->unsignedBigInteger('fk_item_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_item_id')->references('item_id')->on('items')->onDelete('cascade');

            $table->unique(['fk_user_id', 'fk_item_id']);
            // You might also add a foreign key constraint for product_id if necessary
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishkart');
    }
}
