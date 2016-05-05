<?php

namespace App\Http\Controllers;

use App\Cart;
use Validator;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;

class CartController extends Controller {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * CartController constructor.
     */
    public function __construct() {
        $this->middleware('auth');
        // Reference the main constructor.
        parent::__construct();
    }


    /**
     * Return the Cart page with the cart items and total
     * 
     * @return mixed
     */
    public function showCart() {

        // Set the $user_id the the currently authenticated user
        $user_id = Auth::user()->id;
        
        // Set $cart_books to the member ID, along with the products.
        // ( "products" is coming from the Products() method in the Product.php Model )
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();

        // Set $cart_products to the total in the Cart for that user_id to check and see if the cart is empty
        $cart_total = Cart::with('books')->where('user_id', '=', $user_id)->sum('total');

        // From Traits/SearchTrait.php
        // Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // Get brands to display left nav-bar
        $brands = $this->BrandsAll();

        // Count all the products in a cart  with the currently signed in user
        $count = Cart::where('user_id', '=', $user_id)->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        // Return the cart with products, and total amount in cart
        return view('cart.cart', compact('search', 'categories', 'brands', 'count', 'cart_count'))
            ->with('cart_products', $cart_products)
            ->with('cart_total', $cart_total);
    }


    /**
     * Add Products to the cart
     * 
     * @return mixed
     */
    public function addCart() {

        // Assign validation rules
        $rules = array(
            'qty' => 'required|numeric',
            'product'   => 'required|numeric|exists:products,id'
        );

        // Apply validation
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, show error message
        if ($validator->fails()) {
            flash()->error('Error', 'The product could not added to your cart!');
            return redirect()->back();
        }

        // Set $user_id to the currently signed in user ID
        $user_id = Auth::user()->id;

        // Set $product_id to the hidden product input field in the add to cart from
        $product_id = Input::get('product');

        // Set the $qty to the quantity of products selected
        $qty = Input::get('qty');

        // Get the ID of the Products in the cart
        $product = Product::find($product_id);

        // set total to quantity * the product price
        // $total = $qty * $product->price;

        if ($product->reduced_price == 0) {
            $total = $qty * $product->price;
        } else {
            $total = $qty * $product->reduced_price;
        }

        // Create the Cart
        Cart::create(
            array (
                'user_id'    => $user_id,
                'product_id' => $product_id,
                'qty'        => $qty,
                'total'      => $total
            )
        );

        // then redirect back
        return redirect()->route('cart');

    }


    /**
     * Update the Cart
     * 
     * @return mixed
     */
    public function update() {
        
        // Set $user_id to the currently signed in user ID
        $user_id = Auth::user()->id;

        // Set the $qty to the quantity of products selected
        $qty = Input::get('qty');

        // Set $product_id to the hidden product input field in the update cart from
        $product_id = Input::get('product');

        // Set $cart_id to the hidden cart_id input field in the update cart from
        $cart_id = Input::get('cart_id');
        
        // Find the ID of the products in the Cart
        $product = Product::find($product_id);

        if ($product->reduced_price == 0) {
            $total = $qty * $product->price;
        } else {
            $total = $qty * $product->reduced_price;
        }

        // Select ALL from cart where the user ID = to the current logged in user, product_id = the current product ID being updated, and the cart_id = to the cartId being updated
        $cart = Cart::where('user_id', '=', $user_id)->where('product_id', '=', $product_id)->where('id', '=', $cart_id);

        // Update your cart
        $cart->update(array(
            'user_id'    => $user_id,
            'product_id' => $product_id,
            'qty'        => $qty,
            'total'      => $total
        ));

        return redirect()->route('cart');
    }
    

    /**
     * Delete a product from a users Cart
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        // Find the Carts table and given ID, and delete the record
        Cart::find($id)->delete();

        // Then redirect back
        return redirect()->back();
    }
    
    
}