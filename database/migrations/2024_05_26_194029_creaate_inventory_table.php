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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('inventory_id');
            $table->unsignedBigInteger('fk_item_id');
            $table->unsignedBigInteger('fk_admin_id');
            $table->string('location');
            $table->integer('quantity');
            $table->text('vendor')->nullable();
            $table->text('remark')->nullable();
            // // // // // $table->text('transporter')->nullable(); FUTURE USE
            // // // // // $table->text('transport_charge')->nullable(); FUTURE USE
            $table->timestamp('created_at');

            $table->foreign('fk_item_id')->references('item_id')->on('items')->onDelete('cascade');
            $table->foreign('fk_admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
