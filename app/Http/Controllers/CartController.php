<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));

    }

    public function addToCart(Request $request) : RedirectResponse
    {

        


        // // Retrieve the submitted form data
        // $tshirtImage = $request->input('orderItem');
        // $size = $request->input('size');
        // $color = $request->input('color');
        // $quantity = $request->input('quantity');

        // // Implement your cart logic here, such as storing the item in the cart session or database

        // // Optionally, you can redirect the user to the cart page or a success message
        // return redirect()->route('cart')->with('success', 'Item added to cart successfully');
    }
}
