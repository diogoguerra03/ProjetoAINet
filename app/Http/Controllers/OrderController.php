<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {

        $cart = Session::get('cart', []);

        // get last order_id of order_items table
        $lastOrder = OrderItem::orderBy('order_id', 'desc')->pluck('order_id')->first();
        $thisOrderId = $lastOrder + 1;

        // Assuming you have an authenticated user
        $user = Auth::user();

        // Assuming the order is associated with the user
        $order = new Order();
        $order->user_id = $user->id;
        $order->save();

        // Iterate over the cart items and create OrderItem records
        foreach ($cart as $item) {
            $order->orderItems()->create([
                'order_id'        => $thisOrderId,
                'tshirt_image_id' => $item['product_id'],
                'color_code'      => $item['color_code'],
                'size'            => $item['size'],
                'quantity'        => $item['quantity'],
                'price'           => $item['price'],
                'sub_total'       => $item['price'] * $item['quantity'],
                $order->save(),
            ]);
        }

        // Clear the cart
        $request->session()->forget('cart');


        return redirect()->back()
            ->with('alert-msg', "Order submited successfuly.")
            ->with('alert-type', 'success');

    }
}
