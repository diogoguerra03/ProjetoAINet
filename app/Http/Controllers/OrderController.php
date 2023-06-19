<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Color;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\TshirtImage;
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


        $order->status = 'pending';
        $order->customer_id = $customer->id;
        $order->date = Carbon::now()->format('Y-m-d');
        $order->total_price = 0;
        $order->notes = null;
        $order->nif = $customer->nif;
        $order->address = $customer->address;
        $order->payment_type = $customer->default_payment_type;
        $order->payment_ref = $customer->default_payment_ref;
        $order->save();

        $order_id = Order::orderBy('id', 'desc')->pluck('id')->first();
        // Iterate over the cart items and create OrderItem records
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order_id;
            $orderItem->tshirt_image_id = $item['product_id'];
            $orderItem->color_code = $item['color_code'];
            $orderItem->size = $item['size'];
            $orderItem->qty = $item['quantity'];
            $orderItem->unit_price = $item['price'];
            $orderItem->sub_total = $item['price'] * $item['quantity'];
            $total_price += $orderItem->sub_total;
            $orderItem->save();
        }

        $order->total_price = $total_price;
        $order->save();

        // ver ficha 9 transaçao

        // Clear the cart
        $request->session()->forget('cart');


        return redirect()->back()
            ->with('alert-msg', "Order submited successfuly.")
            ->with('alert-type', 'success');

    }

    public function showOrderHistory()
    {
        $user = auth()->user(); // Assuming you're using Laravel's authentication
        $orders = Order::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $orderItems = [];

        foreach ($orders as $order) {
            $order_id = $order->id;
            $orderItems[$order_id] = OrderItem::where('order_id', $order_id)->get();


            foreach ($orderItems[$order_id] as $orderItem) {
                $tshirt = TshirtImage::find($orderItem->tshirt_image_id);
                $tshirts[$orderItem->id] = [
                    'name' => $tshirt ? $tshirt->name : '',
                    'image_url' => $tshirt ? $tshirt->image_url : '',
                ];

                $color = Color::where('code', $orderItem->color_code)->pluck('name')->first();
                $colors[$orderItem->id] = $color ? $color : '';
            }
        }

        return view('history.order', compact('orders', 'orderItems', 'tshirts', 'colors'));
    }

}
