<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
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

    public function orders()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return view('dashboard.orders', compact('orders'));
    }
}
