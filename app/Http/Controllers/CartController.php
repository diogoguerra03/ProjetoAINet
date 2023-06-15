<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\View\View;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = Session::get('cart', []);

        return view('cart.show', ['cart' => $cart,]);
    }

    public function addToCart(Request $request): RedirectResponse
    {

        $productId = $request->input('orderItem');
        $size = $request->input('size');
        $color = $request->input('color');
        $quantity = $request->input('quantity');

        // product_id => imagem do produto
        $tshirtImage = TshirtImage::findOrFail($productId)->image_url;
        $checkClientNull = TshirtImage::findOrFail($productId)->customer_id;
        $quantityDiscount = Price::pluck('qty_discount')->first();
        $price = 0;

        if ($checkClientNull == null) {
            if ($quantity >= $quantityDiscount)
                $price = Price::pluck('unit_price_catalog_discount')->first();
            else
                $price = Price::pluck('unit_price_catalog')->first();
        } else {
            if ($quantity >= $quantityDiscount)
                $price = Price::pluck('unit_price_own_discount')->first();
            else
                $price = Price::pluck('unit_price_own')->first();
        }


        $item = [
            'product_id'   => $productId,
            'tshirt_image' => $tshirtImage,
            'quantity'     => $quantity,
            'color'        => $color,
            'size'         => $size,
            'price'        => $price * $quantity,
        ];

        // Adicionar o item ao carrinho na sessão
        $cart = Session::get('cart', []);
        $cart[] = $item;
        Session::put('cart', $cart);

        // Redirecionar de volta ao catálogo ou a outra página
        return redirect()->back()
        ->with('alert-msg', "$quantity x $tshirtImage adicionado ao carrinho.")
        ->with('alert-type', 'success');

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
