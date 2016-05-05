<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class OrderByController extends ProductsController {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /****************** Order By for Category Section *****************************************************************/


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceHighest($id, Product $product) {

        // Get the Category ID
        $categories = Category::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Order Products by price highest, where the category id = the URl route ID
        $products = Product::orderBy('price', 'desc')->where('cat_id', '=', $id)->paginate(15);

        // Count the Products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceLowest($id, Product $product) {

        // Get the Category ID
        $categories = Category::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Order Products by price lowest, where the category id = the URl route ID
        $products = Product::orderBy('price', 'asc')->where('cat_id', '=', $id)->paginate(15);

        // Count the Products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }



    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaHighest($id, Product $product) {

        // Get the Category ID
        $categories = Category::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Order Products by Alphabet Descending, where the category id = the URl route ID
        $products = Product::orderBy('product_name', 'desc')->where('cat_id', '=', $id)->paginate(15);

        // Count the Products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaLowest($id, Product $product) {

        // Get the Category ID
        $categories = Category::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Order Products by Alphabet Ascending, where the category id = the URl route ID
        $products = Product::orderBy('product_name', 'asc')->where('cat_id', '=', $id)->paginate(15);

        // Count the Products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands','search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsNewest($id, Product $product) {

        // Get the Category ID
        $categories = Category::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Order Products by newest products, where the category id = the URl route ID
        $products = Product::orderBy('created_at', 'desc')->where('cat_id', '=', $id)->paginate(15);

        // Count the products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }




    /****************** Order By for Brands Section *******************************************************************/


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceHighestBrand($id, Product $product) {

        // Get the Brand ID
        $brands = Brand::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brand = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        $products = Product::orderBy('price', 'desc')->where('brand_id', '=', $id)->paginate(15);

        // Count the products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'brand', 'category', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceLowestBrand($id, Product $product) {


        // Get the Brand ID
        $brands = Brand::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brand = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        $products = Product::orderBy('price', 'asc')->where('brand_id', '=', $id)->paginate(15);

        // Count the products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'category', 'brand', 'search', 'count', 'cart_count'));
    }



    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaHighestBrand($id, Product $product) {

        // Get the Brand ID
        $brands = Brand::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brand = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        $products = Product::orderBy('product_name', 'desc')->where('brand_id', '=', $id)->paginate(15);

        // Count the products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'category', 'brand', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaLowestBrand($id, Product $product) {

        // Get the Brand ID
        $brands = Brand::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brand = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        $products = Product::orderBy('product_name', 'asc')->where('brand_id', '=', $id)->paginate(15);

        // Count the products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'category', 'brand', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsNewestBrand($id, Product $product) {

        // Get the Brand ID
        $brands = Brand::where('id', '=', $id)->get();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $category = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brand = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        $products = Product::orderBy('created_at', 'desc')->where('brand_id', '=', $id)->paginate(15);

        // Count the products
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'category', 'brand', 'search', 'count', 'cart_count'));
    }


}