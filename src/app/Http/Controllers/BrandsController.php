<?php 

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;

use App\Http\Traits\CartTrait;
use App\Http\Traits\BrandAllTrait;
use Illuminate\Support\Facades\Auth;


class BrandsController extends Controller {

    use BrandAllTrait, CartTrait;


    /**
     * Return the Show Brands Table.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('admin.brand.show', compact('brands', 'cart_count'));
    }


    /**
     * Return all Products under brands
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProductsForBrand($id) {

        // Get the Brand name under this id
        $brands = Brand::where('id', '=', $id)->get();

        // Get all products under this brand
        $products = Product::where('brand_id', '=', $id)->get();

        // Count to see if there are any products under this brand
        $count = Product::where('brand_id', '=', $id)->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('admin.brand.show_products', compact('brands', 'products', 'count', 'cart_count'));
    }


    /**
     * Show the create Brand view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('admin.brand.create', compact('cart_count'));
    }


    /**
     * Store the Brands in DB
     *
     * @param BrandsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BrandsRequest $request) {

        // Get all the validation rules for Brands and assign it to the Brand Model
        $brands = new Brand($request->all());

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot create Brand because you are signed in as a test user.');
        } else {
            // Save the Brands in DB
            $brands->save();

            // Flash a success message
            flash()->success('Success', 'Brand created successfully!');
        }

        // Redirect back to Show all brands page.
        return redirect('admin/brands');
    }


    /**
     * Return edit blade with Brand
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id) {

        // Get a brand with an ID that is the same as in URL
        $brands = Brand::where('id', '=', $id)->find($id);

        // If no brand exists with some particular Id, then redirect back to Show Brands Page.
        if (!$brands) {
            return redirect('admin/brands');
        }

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();


        // Return view with brands
        return view('admin.brand.edit', compact('brands', 'cart_count'));
    }


    /**
     * Update a Brand
     *
     * @param $id
     * @param BrandsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, BrandsRequest $request) {

        // Find the brand ID in URL route
        $brands = Brand::findOrFail($id);


        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot edit Brand because you are signed in as a test user.');
        } else {
            // Update the brand with Request rules
            $brands->update($request->all());

            // Flash success message
            flash()->success('Success', 'Brand update successfully!');
        }

        return redirect('admin/brands');
    }


    /**
     * Delete a Brand from DB
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {

        // Find the Brand ID in the URl route
        $delete = Brand::findOrFail($id);

        // Get all products under this sub-category
        $products = Product::where('brand_id', '=', $id)->count();

        // If there are any products under a brand, then throw
        // a error overlay message, saying to delete all products under the
        // brand, else delete the brand
        if ($products > 0) {
            // Flash a error overlay message
            flash()->customErrorOverlay('Error', 'There are products under this brand. Cannot delete this brand until all products under this brand are deleted');
        } elseif (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot delete Brand because you are signed in as a test user.');
        } else {
            $delete->delete();
        }

        return redirect()->back();
    }


}