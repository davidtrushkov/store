<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'product_name' => 'Xbox One - Turtle Beach X-40 Headset',
            'price'        =>  29.89,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'product_name' => 'Xbox One - Elite Controller',
            'price'        => 150.00,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'product_name' => 'Means Levi Jeans - Dark Blue',
            'price'        => 59.89,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
