<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $ColorIdArray = [];
        for($color = 0;$color < 10; $color++){
            $ColorIdArray[] = DB::table('colors')->insertGetId([
                'color_name' => $faker->randomElement(['Red', 'Green', 'Blue', 'Yellow', 'Orange', 'Purple', 'Navy Blue', 'Maroon', 'Dark Blue']),
                'color_code' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))
            ]);
        };
        $SizeIdArray = [];
        for($size = 0;$size < 10; $size++){
            $SizeIdArray[] = DB::table('sizes')->insertGetId([
                'size_name' => $faker->words(5, true),
                'size_code' => $faker->randomElement(['S', 'M', 'L', 'XL', 'FREE', 'XL', 'XXL', 'XXXL'])
            ]);
        };
        // Insert data into the categories table
        for ($i = 0; $i < 3; $i++) {
            $categoryId = DB::table('categories')->insertGetId([
                'category_name' => $faker->word,
                'c_description' => $faker->sentence,
                'c_keywords' => $faker->words(3, true)
            ]);

            // Insert products for each category
            for ($j = 0; $j < 3; $j++) {
                $productId = DB::table('products')->insertGetId([
                    'fk_category_id' => $categoryId,
                    'product_code' => strtoupper($faker->lexify('??????')),
                    'product_name' => $faker->word,
                    'p_description' => $faker->sentence,
                    'p_keywords' => $faker->words(5, true),
                    'gender' => $faker->randomElement(['M', 'F']),
                    'status' => $faker->randomElement([0, 1]),
                    'priority' => $faker->numberBetween(1, 10)
                ]);

                // Insert items for each product
                for ($k = 0; $k < 3; $k++) {
                    $itemId = DB::table('items')->insertGetId([
                        'fk_category_id' => $categoryId,
                        'fk_product_id' => $productId,
                        'fk_color_id' => $faker->randomElement($ColorIdArray), // Assuming you have a table named 'colors'
                        'fk_size_id' => $faker->randomElement($SizeIdArray), // Assuming you have a table named 'sizes'
                        'mrp' => $faker->numberBetween(100, 1000),
                        'price' => $faker->numberBetween(50, 800),
                        'cost_price' => $faker->numberBetween(50, 600),
                        'stock' => 0,
                        'status' => $faker->randomElement([0, 1]),
                        'priority' => $faker->numberBetween(1, 5)
                    ]);

                    // Upload images for each item
                    // for ($l = 1; $l <= rand(1, 7); $l++) {
                    //     $imageName = $faker->word . '.jpg'; // Generate a random image name
                    //     DB::table('item_images')->insert([
                    //         'fk_item_id' => $itemId,
                    //         'url' => $imageName,
                    //         'created_at' => now()
                    //     ]);

                    //     // Now, you can move the uploaded image to the desired directory
                    //     // Example: move_uploaded_file($imageTempPath, 'path/to/your/upload/directory/' . $imageName);
                    // }
                }
            }
        }
    }
}
