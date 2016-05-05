<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductEditRequest;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class ProductsController extends Controller {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Show all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProducts() {

        // Get all latest products, and paginate them by 10 products per page
        $product = Product::latest('created_at')->paginate(10);

        // Count all Products in Products Table
        $productCount = Product::all()->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('admin.product.show', compact('productCount', 'product', 'cart_count'));
    }


    /**
     * Return the view for add new product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addProduct() {
        // From Traits/CategoryTrait.php
        // ( This is to populate the parent category drop down in create product page )
        $categories = $this->parentCategory();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('admin.product.add', compact('categories', 'brands', 'cart_count'));
    }


    /**
     * Add a new product into the Database.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPostProduct(ProductRequest $request) {

        // Check if checkbox is checked or not for featured product
        $featured = Input::has('featured') ? true : false;

        // Replace any "/" with a space.
        $product_name =  str_replace("/", " " ,$request->input('product_name'));


       // if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
        //    flash()->error('Error', 'Cannot create Product because you are signed in as a test user.');
       // } else {
            // Create the product in DB
            $product = Product::create([
                'product_name' => $product_name,
                'product_qty' => $request->input('product_qty'),
                'product_sku' => $request->input('product_sku'),
                'price' => $request->input('price'),
                'reduced_price' => $request->input('reduced_price'),
                'cat_id' => $request->input('cat_id'),
                'brand_id' => $request->input('brand_id'),
                'featured' => $featured,
                'description' => $request->input('description'),
                'product_spec' => $request->input('product_spec'),
            ]);

            // Save the product into the Database.
            $product->save();

            // Flash a success message
            flash()->success('Success', 'Product created successfully!');
       // }


        // Redirect back to Show all products page.
        return redirect()->route('admin.product.show');
    }


    /**
     * This method will fire off when a admin chooses a parent category.
     * It will get the option and check all the children of that parent category,
     * and then list them in the sub-category drop-down.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryAPI() {
        // Get the "option" value from the drop-down.
        $input = Input::get('option');

        // Find the category name associated with the "option" parameter.
        $category = Category::find($input);

        // Find all the children (sub-categories) from the parent category
        // so we can display then in the sub-category drop-down list.
        $subcategory = $category->children();

        // Return a Response, and make a request to get the id and category (name)
        return \Response::make($subcategory->get(['id', 'category']));
    }


    /**
     * Return the view to edit & Update the Products
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProduct($id) {

        // Find the product ID
        $product = Product::where('id', '=', $id)->find($id);

        // If no product exists with that particular ID, then redirect back to Show Products Page.
        if (!$product) {
            return redirect('admin/products');
        }

        // From Traits/CategoryTrait.php
        // ( This is to populate the parent category drop down in create product page )
        $categories = $this->parentCategory();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->BrandsAll();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        // Return view with products and categories
        return view('admin.product.edit', compact('product', 'categories', 'brands', 'cart_count'));

    }


    /**
     * Update a Product
     *
     * @param $id
     * @param ProductEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct($id, ProductEditRequest $request) {

        // Check if checkbox is checked or not for featured product
        $featured = Input::has('featured') ? true : false;

        // Find the Products ID from URL in route
        $product = Product::findOrFail($id);


        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot edit Product because you are signed in as a test user.');
        } else {
            // Update product
            $product->update(array(
                'product_name' => $request->input('product_name'),
                'product_qty' => $request->input('product_qty'),
                'product_sku' => $request->input('product_sku'),
                'price' => $request->input('price'),
                'reduced_price' => $request->input('reduced_price'),
                'cat_id' => $request->input('cat_id'),
                'brand_id' => $request->input('brand_id'),
                'featured' => $featured,
                'description' => $request->input('description'),
                'product_spec' => $request->input('product_spec'),
            ));


            // Update the product with all the validation rules
            $product->update($request->all());

            // Flash a success message
            flash()->success('Success', 'Product updated successfully!');
        }

        // Redirect back to Show all categories page.
        return redirect()->route('admin.product.show');
    }


    /**
     * Delete a Product
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct($id) {

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot delete Product because you are signed in as a test user.');
        } else {
            // Find the product id and delete it from DB.
            Product::findOrFail($id)->delete();
        }

        // Then redirect back.
        return redirect()->back();
    }


    /**
     * Display the form for uploading images for each Product
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayImageUploadPage($id) {

        // Get the product ID that matches the URL product ID.
        $product = Product::where('id', '=', $id)->get();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('admin.product.upload', compact('product', 'cart_count'));
    }


    /**
     * Show a Product in detail
     *
     * @param $product_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($product_name) {

        // Find the product by the product name in URL
        $product = Product::ProductLocatedAt($product_name);

        // From Traits/SearchTrait.php
        // Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // Get brands to display left nav-bar
        $brands = $this->BrandsAll();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();


        $similar_product = Product::where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('brand_id', '=', $product->brand_id)
                    ->orWhere('cat_id', '=', $product->cat_id);
            })->get();

        return view('pages.show_product', compact('product', 'search', 'brands', 'categories', 'similar_product', 'cart_count'));
    }


}