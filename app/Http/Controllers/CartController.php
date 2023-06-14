<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = Session::get('cart', []);
        return view('cart.show', ['cart' => $cart]);

    }

    public function addToCart(Request $request): RedirectResponse
    {


        $productId = $request->input('orderItem');
        $size = $request->input('size');
        $color = $request->input('color');
        $quantity = $request->input('quantity');

        $item = [
            'product_id' => $productId,
            'quantity'   => $quantity,
            'color'      => $color,
            'size'       => $size,
        ];

        // Adicionar o item ao carrinho na sessão
        $cart = Session::get('cart', []);
        $cart[] = $item;
        Session::put('cart', $cart);

        // Redirecionar de volta ao catálogo ou a outra página
        return redirect()->back()->with('success', 'Item adicionado ao carrinho com sucesso.');

    }

    public function removeFromCart($index)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removido do carrinho com sucesso.');
    }
}
