<?php 

namespace App\Http\Controllers;

use App\Product;
use App\ProductPhoto;
use App\AddPhotoToProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ProductPhotoRequest;

class ProductPhotosController extends Controller {


    /**
     * @param $id
     * @param ProductPhotoRequest $request
     */
    public function store($id, ProductPhotoRequest $request) {
        // Set $product = Product::LocatedAt() in (Product.php Model) = to the id
        // -- Find the product.
        $product = Product::LocatedAt($id);

        // Store the photo from the file instance
        // -- ('photo') is coming from "public/js/dropzone.forms.js" --
        $photo = $request->file('photo');

        // Create dedicated class to add photos to product, and save the photos.
        (new AddPhotoToProduct($product, $photo))->save();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        // Find the photo and delete it.
        ProductPhoto::findOrFail($id)->delete();
        // Then return back;
        return back();
    }


    /**
     * Store and update the featured photo for a product
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFeaturedPhoto($id, Request $request) {
        // Validate featured button
        $this->validate($request, [
            'featured' => 'required|exists:product_images,id'
        ]);

        // Grab the ID of the Image being featured from radio button
        $featured = Input::get('featured');

        // Select from "product_images" where the 'product_id' = the ID in the URL, and update "featured" column to 0
        ProductPhoto::where('product_id', '=', $id)->update(['featured' => 0]);

        // Find the $featured result and update "featured" column to 1
        ProductPhoto::findOrFail($featured)->update(['featured' => 1]);


        // Return redirect back
        return redirect()->back();
    }


}