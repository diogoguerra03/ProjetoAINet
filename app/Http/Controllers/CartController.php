<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));

    }

    public function addToCart(Request $request) : RedirectResponse
    {

        // Retrieve the submitted form data
        $tshirtImage = $request->session()->get('orderItem');
        $size = $request->session()->get('size');
        $color = $request->session()->get('color');
        $quantity = $request->session()->get('quantity');

        // Implement your cart logic here, such as storing the item in the cart session or database

        // Optionally, you can redirect the user to the cart page or a success message
        return redirect()->route('cart.show')->with('success', 'Item added to cart successfully');
    }
}

