<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('product_name');
            $table->integer('product_qty');
            $table->integer('product_sku')->unsigned();
            $table->decimal('price', 10, 2)->unsigned();
            $table->decimal('reduced_price', 10, 2)->unsigned()->nullable();
            $table->integer('cat_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('featured')->default(0);
            $table->text('description');
            $table->text('product_spec')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
