<?php
namespace App\Http\Traits;

use App\Brand;

trait BrandAllTrait {


    public function brandsAll() {
        // Get all the brands from the Brands Table.
        return Brand::all();
    }


}