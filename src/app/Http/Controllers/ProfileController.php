<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Http\Controllers\Controller;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class ProfileController extends Controller {


    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /* This page uses the Auth Middleware */
    public function __construct() {
        $this->middleware('auth');
        // Reference the main constructor.
        parent::__construct();
    }


    /**
     * Display Profile contents
     *
     * @return mixed
     */
    public function index() {

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        // Get the currently authenticated user
        $username = \Auth::user();

        // Set user_id to the currently authenticated user ID
        $user_id = $username->id;

        // Select all from "Orders" where the user_id = the ID og the signed in user to get all their Orders
        $orders = Order::where('user_id', '=', $user_id)->get();

        return view('profile.index', compact('categories', 'brands', 'search', 'cart_count', 'username', 'orders'));
    }
    

}