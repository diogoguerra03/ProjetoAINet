<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Color;
use App\Models\Order;
use App\Models\Price;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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

    public function showOrders(Request $request)
    {
        $filterByOrderID = $request->order_id ?? '';
        $filterByCustID = $request->customer_id ?? '';
        $filterByStatus = $request->status ?? '';


        $ordersQuery = Order::query()->orderByDesc('created_at');


        if ($filterByStatus !== '') {
            $ordersQuery = $ordersQuery->where('status', $filterByStatus);
        }

        if ($filterByCustID !== '') {
            $ordersQuery = $ordersQuery->where('customer_id', $filterByCustID);
        }

        if ($filterByOrderID !== '') {
            $ordersQuery = $ordersQuery->where('id', $filterByOrderID);
        }

        $orders = $ordersQuery->paginate(50);

        return view('dashboard.orders', compact('orders', 'filterByStatus', 'filterByCustID', 'filterByOrderID'));
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

        $tshirts = [];
        $colors = [];

        foreach ($orderItems as $orderItem) {
            $tshirt = TshirtImage::find($orderItem->tshirt_image_id);
            $tshirts[$orderItem->id] = [
                'name'      => $tshirt ? $tshirt->name : '',
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

    public function employeeUpdate(Request $request, User $employee)
    {
        $employee->blocked = $request->blocked ? 1 : 0;
        $employee->save();

        return redirect()->back()
            ->with('alert-msg', "Employee no. $employee->id updated successfully.")
            ->with('alert-type', 'success');
    }

    public function edit(User $employee)
    {
        return view('dashboard.edit', compact('employee'));
    }

    public function addEmployee()
    {
        return view('dashboard.addEmployee');
    }

    public function deleteAdmin(User $admin)
    {
        if ($admin->user_type != 'A') {
            return redirect()->back()
                ->with('alert-msg', "User no. $admin->id is not an admin.")
                ->with('alert-type', 'danger');
        } else {
            $admin->delete();


        }
        return redirect()->back()
            ->with('alert-msg', "Admin no. $admin->id deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function adminUpdate(Request $request, User $admin)
    {
        $admin->blocked = $request->blocked ? 1 : 0;
        $admin->save();

        return redirect()->back()
            ->with('alert-msg', "Admin no. $admin->id updated successfully.")
            ->with('alert-type', 'success');
    }

    public function showPrices()
    {
        $price = Price::all()->first();
        return view('dashboard.prices', compact('price'));
    }

    public function updatePrices(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $price = Price::first();
                $price->unit_price_catalog = $request->input('unit_price_catalog');
                $price->unit_price_catalog_discount = $request->input('unit_price_catalog_discount');
                $price->unit_price_own = $request->input('unit_price_own');
                $price->unit_price_own_discount = $request->input('unit_price_own_discount');
                $price->qty_discount = $request->input('qty_discount');

                $price->save();
            });

            return redirect()->back()
                ->with('alert-msg', "Price updated successfully.")
                ->with('alert-type', 'success');
        } catch (QueryException $e) {
            // Handle the exception and return an error message
            return redirect()->back()
                ->with('alert-msg', "Failed to update price. Error: " . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }

}

