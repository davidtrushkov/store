<?php
namespace App\Http\Traits;

use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

trait CartTrait {


    
    public function countProductsInCart() {

        if (Auth::check()) {
            // Grt the currently signed in user ID to count how many items in their cart
            $user_id = Auth::user()->id;

            // Count ho man items in cart for signed in user
            return $cart_count = Cart::where('user_id', '=', $user_id)->count();
        }

    }
    

}