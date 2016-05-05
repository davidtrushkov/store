<?php
namespace App\Http\Traits;

use App\Product;
use Illuminate\Support\Facades\Input;

trait SearchTrait {


    /**
     * Perform search capabilities for search bar
     *
     * @return mixed
     */
    public function search() {

        // Gets the query string from our form submission
        $query = Input::get('search');

        // Returns an array of products that have the query string located somewhere within
        // our products product name. Paginate them so we can break up lots of search results.
        return Product::where('product_name', 'LIKE', '%' . $query . '%')->paginate(200);

    }


}