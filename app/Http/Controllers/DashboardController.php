<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Color;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\TshirtImage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = TshirtImage::count();
        $ordersPlaced = Order::count();
        $moneyEarned = Order::where('status', 'closed')->sum('total_price'); // só contabiliza as orders fechadas
        $numberCustomers = User::where('user_type', 'C')->count();

        return view('dashboard.index', compact('totalProducts', 'ordersPlaced', 'numberCustomers', 'moneyEarned'));
    }

    public function customers()
    {
        $customers = User::where('user_type', 'C')->get();

        return view('dashboard.customers', compact('customers'));
    }

    public function employees()
    {
        $employees = User::where('user_type', 'E')->get();

        return view('dashboard.employees', compact('employees'));
    }

    public function admins()
    {
        $admins = User::where('user_type', 'A')->get();

        return view('dashboard.admins', compact('admins'));
    }

    public function showOrders()
    {
        $orders = Order::all()->sortByDesc('created_at');

        return view('dashboard.orders', compact('orders'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return redirect()->back()
            ->with('alert-msg', "Order no. $order->id updated to \"$order->status\" successfully.")
            ->with('alert-type', 'success');
    }

    public function showDetails(Order $order)
    {
        $user = User::where('id', $order->customer_id)->first();
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $customer = Customer::where('id', $order->customer_id)->first();
        $user = User::where('id', $customer->id)->first();

        $tshirts = [];
        $colors = [];

        foreach ($orderItems as $orderItem) {
            $tshirt = TshirtImage::find($orderItem->tshirt_image_id);
            $tshirts[$orderItem->id] = [
                'name' => $tshirt ? $tshirt->name : '',
                'image_url' => $tshirt ? $tshirt->image_url : '',
            ];

            $color = Color::where('code', $orderItem->color_code)->pluck('name')->first();
            $colors[$orderItem->id] = $color ? $color : '';
        }

        return view('dashboard.orderDetails', compact('order', 'user', 'tshirts', 'colors', 'orderItems'));
    }


    public function deleteCustomer(User $customer)
    {
        if ($customer->user_type != 'C') {
            return redirect()->back()
                ->with('alert-msg', "User no. $customer->id is not a customer.")
                ->with('alert-type', 'danger');
        } else {
            $customer->delete();
        }


        return redirect()->back()
            ->with('alert-msg', "Customer no. $customer->id deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function customerUpdate(Request $request, User $customer)
    {
        $customer->blocked = $request->blocked ? 1 : 0;
        $customer->save();

        return redirect()->back()
            ->with('alert-msg', "Customer no. $customer->id updated successfully.")
            ->with('alert-type', 'success');
    }

    public function deleteEmployee(User $employee)
    {
        if ($employee->user_type != 'E') {
            return redirect()->back()
                ->with('alert-msg', "User no. $employee->id is not an employee.")
                ->with('alert-type', 'danger');
        } else {
            $employee->delete();


            return redirect()->back()
                ->with('alert-msg', "Employee no. $employee->id deleted successfully.")
                ->with('alert-type', 'success');
        }
    }

    public function filterOrders()
    {
        return view('dashboard.orders');
    }

}
