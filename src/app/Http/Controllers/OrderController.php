<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use Validator;
use App\Product;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class OrderController extends Controller {

    
    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Show products in Order view
     * 
     * @return mixed
     */
    public function index() {

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

        // Set the $user_id the the currently authenticated user
        $user_id = Auth::user()->id;

        // Count the items in a signed in users shopping cart
        $check_cart = Cart::with('products')->where('user_id', '=', $user_id)->count();

        // Count all the products in a cart  with the currently signed in user
        $count = Cart::where('user_id', '=', $user_id)->count();

        // If there are no items in users shopping cart, redirect them back to cart
        // page so they cant access checkout view with no items
        if (!$check_cart) {
            return redirect()->route('cart');
        }

        // Set $cart_books to the member ID, along with the products.
        // ( "products" is coming from the Products() method in the Product.php Model )
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();

        // Set $cart_products to the total in the Cart for that user_id to check and see if the cart is empty
        $cart_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('total');

        return view('cart.checkout', compact('search', 'categories', 'brands', 'cart_count', 'count'))
            ->with('cart_products', $cart_products)
            ->with('cart_total', $cart_total);
    }


    /**
     * Make the order when user enters all credentials
     * 
     * @param Request $request
     * @return mixed
     */
    public function postOrder(Request $request) {

        // Validate each form field
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:30|min:2',
            'last_name'  => 'required|max:30|min:2',
            'address'    => 'required|max:50|min:4',
            'address_2'  => 'max:50|min:4',
            'city'       => 'required|max:50|min:3',
            'state'      => 'required|',
            'zip'        => 'required|max:11|min:4',
            'full_name'  => 'required|max:30|min:2',
        ]);


        // If error occurs, display it
        if ($validator->fails()) {
            return redirect('/checkout')
                ->withErrors($validator)
                ->withInput();
        }

        // Set your secret key: remember to change this to your live secret key in production
        Stripe::setApiKey('YOUR STRIPE SECRET KEY');

        // Set Inputs to the the form fields so we can store them in DB
        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $address = Input::get('address');
        $address_2 = Input::get('address_2');
        $city = Input::get('city');
        $state = Input::get('state');
        $zip = Input::get('zip');
        $full_name = Input::get('full_name');

        // Set $user_id to the currently authenticated user
        $user_id = Auth::user()->id;

        // Set $cart_products to the Cart Model with its products where
        // the user_id = to the current signed in user ID
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();

        // Set $cart_total to the Cart Model alond with all its products, and
        // where the user_id = the current signed in user ID, and
        // also get the sum of the total field.
        $cart_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('total');

        //  Get the total, and set the charge amount
        $charge_amount = number_format($cart_total, 2) * 100;

        
        // Create the charge on Stripe's servers - this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                'source' => $request->input('stripeToken'),
                'amount' => $charge_amount, // amount in cents, again
                'currency' => 'usd',
            ));

        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
            echo $e;
        }


        // Create the order in DB, and assign each variable to the correct form fields
        $order = Order::create (
            array(
                'user_id'    => $user_id,
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'address'    => $address,
                'address_2'  => $address_2,
                'city'       => $city,
                'state'      => $state,
                'zip'        => $zip,
                'total'      => $cart_total,
                'full_name'  => $full_name,
            ));

        // Attach all cart items to the pivot table with their fields
        foreach ($cart_products as $order_products) {
            $order->orderItems()->attach($order_products->product_id, array(
                'qty'    => $order_products->qty,
                'price'  => $order_products->products->price,
                'reduced_price'  => $order_products->products->reduced_price,
                'total'  => $order_products->products->price * $order_products->qty,
                'total_reduced'  => $order_products->products->reduced_price * $order_products->qty,
            ));
        }


        // Decrement the product quantity in the products table by how many a user bought of a certain product.
        \DB::table('products')->decrement('product_qty', $order_products->qty);

        
        // Delete all the items in the cart after transaction successful
        Cart::where('user_id', '=', $user_id)->delete();
        
        // Then return redirect back with success message
        flash()->success('Success', 'Your order was processed successfully.');

        return redirect()->route('cart');

    }
    

}