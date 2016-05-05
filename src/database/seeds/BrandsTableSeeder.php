<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'brand_name' => 'Apple',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'SONY',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'Microsoft',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'LG',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'Astro Gaming',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'Samsung',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'DELL',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'HP',
        ]);

        DB::table('brands')->insert([
            'brand_name' => 'Turtle Beach',
        ]);
    }

}
