<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Traits\CartTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller {

    use CartTrait;


    /**
     * Show the Admin Dashboard
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();
        
        // Get all the orders in DB
        $orders = Order::all();

        // Get the grand total of all totals in orders table
        $count_total = Order::sum('total');

        // Get all the users in DB
        $users = User::all();
        
        
        // Get all the carts in DB
        $carts = Cart::all();

        // Get all the carts in DB
        $products = Product::all();
        
        // Select all from Products where the Product Quantity = 0
        $product_quantity = Product::where('product_qty', '=', 0)->get();

        return view('admin.pages.index', compact('cart_count', 'orders', 'users', 'carts', 'count_total', 'products', 'product_quantity'));
    }
    

    /**
     * Delete a user
     * 
     * @param $id
     * @return mixed
     */
    public function delete($id) {

        // Find the product id and delete it from DB.
        $user = User::findOrFail($id);

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot delete users because you are signed in as a test user.');
        } elseif ($user->admin == 1) {
            // If user is a admin, don't delete the user, else delete a user
            flash()->error('Error', 'Cannot delete Admin.');
        } else {
            $user->delete();
        }

        // Then redirect back.
        return redirect()->back();
    }


    /** Delete a cart session
     * 
     * @param $id
     * @return mixed
     */
    public function deleteCart($id) {
        // Find the product id and delete it from DB.
        $cart = Cart::findOrFail($id);

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot delete cart because you are signed in as a test user.');
        } else {
            $cart->delete();
        }

        // Then redirect back.
        return redirect()->back();
    }


    /**
     * Update the Product Quantity if empty for Admin dashboard
     * 
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request) {

        // Validate email and password.
        $this->validate($request, [
            'product_qty' => 'required|max:2|min:1',
        ]);

        // Set the $qty to the quantity inserted
        $qty = Input::get('product_qty');

        // Set $product_id to the hidden product input field in the update cart from
        $product_id = Input::get('product');

        // Find the ID of the products in the Cart
        $product = Product::find($product_id);

        $product_qty = Product::where('id', '=', $product_id);

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            flash()->error('Error', 'Cannot update product quantity because you are signed in as a test user.');
        } else {
            // Update your product qty
            $product_qty->update(array(
                'product_qty' => $qty
            ));
        }


        return redirect()->back();
        
    }

    

}