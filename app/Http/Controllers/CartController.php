<?php

namespace App\Http\Controllers;

use App\Models\Color;
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

        $productId = $request->input('tshirtId');
        $productName = $request->input('tshirtName');
        $productUrl = $request->input('tshirtUrl');
        $size = $request->input('size');
        $colorCode = $request->input('color') ?? 'fafafa'; // cor default -> branco
        $quantity = $request->input('quantity');

        $checkClientNull = TshirtImage::findOrFail($productId)->customer_id;
        $quantityDiscount = Price::pluck('qty_discount')->first();
        $colorName = Color::where('code', $colorCode)->pluck('name')->first();

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

        // criar o array do item com todas as informações
        $item = [
            'product_id'   => $productId,
            'product_name' => $productName,
            'tshirt_image' => $productUrl,
            'quantity'     => $quantity,
            'color'        => $colorName,
            'color_code'   => $colorCode,
            'size'         => $size,
            'price'        => $price,
        ];

        // Adicionar o item ao carrinho na sessão
        $cart = Session::get('cart', []);
        $cart[] = $item;
        Session::put('cart', $cart);

        // Redirecionar de volta ao catálogo ou a outra página
        return redirect()->back()
            ->with('alert-msg', "$quantity x \"$productName\" ($size - $colorName) added to cart.")
            ->with('alert-type', 'success');

    }

    public function removeFromCart($index)
    {
        $cart = Session::get('cart', []);

        $tshirtName = $cart[$index]['product_name'];
        $tshirtQuantity = $cart[$index]['quantity'];
        $tshirtSize = $cart[$index]['size'];
        $tshirtColor = $cart[$index]['color'];

        if (isset($cart[$index])) {
            unset($cart[$index]);
            Session::put('cart', $cart);
        }

        return redirect()->back()
            ->with('alert-msg', "$tshirtQuantity x \"$tshirtName\" ($tshirtSize - $tshirtColor) removed from cart.")
            ->with('alert-type', 'success');
    }

    public function getfile(string $slug)
    {
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));
        $path = $tshirtImage->image_url;
        $customerID = $tshirtImage->customer_id;
        $user = auth()->user();
        if ($customerID !== null && $user !== null && $user->id === $customerID) {
            return response()->file(storage_path('app/tshirt_images_private/' . $path));
        }
        return response()->file(public_path('storage/tshirt_images/' . $path));
    }
}