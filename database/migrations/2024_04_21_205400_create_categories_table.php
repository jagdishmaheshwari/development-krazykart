<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 100);
            $table->text('c_description')->nullable();
            $table->text('c_keywords')->nullable();
        });

        // Insert data into the table
        DB::table('categories')->insert([
            [
                'category_name' => 'Saree',
                'c_description' => 'Description For Saree',
                'c_keywords' => 'Keyword For Saree'
            ],
            [
                'category_name' => 'Kurta',
                'c_description' => 'Description for Kurta',
                'c_keywords' => 'kurta men/women'
            ],
            [
                'category_name' => 'Dress',
                'c_description' => 'Description for Dresses',
                'c_keywords' => 'dress ladies women'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
