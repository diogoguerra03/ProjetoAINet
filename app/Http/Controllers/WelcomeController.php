<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WelcomeController extends Controller
{
    public function index()
    {
        $popularProducts = TshirtImage::leftJoin('order_items', 'tshirt_images.id', '=', 'order_items.tshirt_image_id')
            ->select('tshirt_images.*', DB::raw('SUM(order_items.qty) as order_quantity'))
            ->groupBy('tshirt_images.id')
            ->orderByDesc('order_quantity')
            ->whereNull('tshirt_images.customer_id')
            ->whereNull('tshirt_images.deleted_at')
            ->take(4)
            ->get();
        $newArrivals = TshirtImage::orderBy('created_at', 'desc')
            ->whereNull('customer_id')
            ->whereNull('deleted_at')
            ->take(4)
            ->get();

        $priceWithoutDiscount = Price::first()->unit_price_catalog;
        $quantityForDiscount = Price::first()->qty_discount;
        $priceWithDiscount = Price::first()->unit_price_catalog_discount;
        $discountPercentage = 100 - (($priceWithDiscount * 100) / $priceWithoutDiscount);

        $price = [
            'withoutDiscount' => $priceWithoutDiscount,
            'quantityForDiscount' => $quantityForDiscount,
            'withDiscount' => $priceWithDiscount,
        ];

        return view('welcome', compact('popularProducts', 'newArrivals', 'price', 'discountPercentage'));
    }
}
