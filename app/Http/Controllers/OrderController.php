<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {

        $cart = Session::get('cart', []);

        // Assuming you have an authenticated user
        $user = Auth::user();
        $customer = Customer::where('id', $user->id)->first();

        $order = new Order();
        $total_price = 0;

        $order->id = Order::orderBy('id', 'desc')->pluck('id')->first();

        // Iterate over the cart items and create OrderItem records

        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->tshirt_image_id = $item['product_id'];
            $orderItem->color_code = $item['color_code'];
            $orderItem->size = $item['size'];
            $orderItem->qty = $item['quantity'];
            $orderItem->unit_price = $item['price'];
            $orderItem->sub_total = $item['price'] * $item['quantity'];
            $total_price += $orderItem->sub_total;
            $orderItem->save();
        }

        $order->status = 'pending';
        $order->costumer_id = $customer->id;
        $order->date = Carbon::now()->format('Y-m-d');
        $order->total_price = $total_price;
        $order->notes = null;
        $order->nif = $customer->nif;
        $order->address = $customer->address;
        $order->payment_type = $customer->default_payment_type;
        $order->payment_ref = $customer->default_payment_ref;
        $order->save();

        // Clear the cart
        $request->session()->forget('cart');


        return redirect()->back()
            ->with('alert-msg', "Order submited successfuly.")
            ->with('alert-type', 'success');

    }
}
