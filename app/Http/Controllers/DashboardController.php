<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAdminEmployee;
use App\Http\Requests\AddEmployee;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ColorRequest;
use App\Http\Requests\UpdateAdminEmployee;
use App\Models\Order;
use App\Models\TshirtImage;
use App\Models\User;
use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

use App\Http\Requests\UpdateUserRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');

    }

    public function index(): View
    {
        $totalProducts = TshirtImage::count();
        $ordersPlaced = Order::count();
        $moneyEarned = Order::where('status', 'closed')->sum('total_price'); // só contabiliza as orders fechadas
        $numberCustomers = User::where('user_type', 'C')->count();

        return view('dashboard.index', compact('totalProducts', 'ordersPlaced', 'numberCustomers', 'moneyEarned'));
    }

    public function chartData()
    {
        $months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];

        $orders = []; // Array para armazenar o número de pedidos por mês

        // Recupere o número de pedidos para cada mês
        foreach ($months as $month) {
            $orders[] = Order::whereMonth('created_at', '=', date('m', strtotime($month)))
                ->whereYear('created_at', '=', date('Y'))
                ->where('orders.status', 'closed')
                ->count();
        }

        return response()->json([
            'months' => $months,
            'orders' => $orders,
        ]);
    }

    public function pieChartData()
    {
        $categories = Category::whereNull('deleted_at')->get(['id', 'name']);
        $quantities = []; // Array para armazenar as quantidades vendidas de cada categoria

        // Recupere a quantidade vendida para cada categoria
        foreach ($categories as $category) {
            $quantity = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
                ->where('tshirt_images.category_id', $category->id)
                ->where('orders.status', 'closed')
                ->sum('order_items.qty');

            $quantities[] = $quantity;
        }

        return response()->json([
            'categories' => $categories->pluck('name'),
            'quantities' => $quantities,
        ]);
    }

    public function customers(Request $request): View
    {
        $filterByID = $request->inputID ?? '';
        $filterByName = $request->inputName ?? '';
        $order = $request->order ?? '';

        $customersQuery = User::query()->where('user_type', 'C');

        if ($filterByID !== '') {
            $customersQuery = $customersQuery->where('id', $filterByID);
        }

        if ($filterByName !== '') {
            $customersQuery = $customersQuery->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        if ($order !==''){
            switch ($order) {
                case 'ascID':
                    $customersQuery = $customersQuery->orderBy('id', 'asc');
                    break;
                case 'descID':
                    $customersQuery = $customersQuery->orderBy('id', 'desc');
                    break;
                case 'ascDate':
                    $customersQuery = $customersQuery->orderBy('created_at', 'asc');
                    break;
                case 'descDate':
                    $customersQuery = $customersQuery->orderBy('created_at', 'desc');
                    break;
                default:
                    $customersQuery = $customersQuery->orderBy('id', 'asc');
                    break;
            }
        }

        $customers = $customersQuery->paginate(50);


        return view('dashboard.customers', compact('customers', 'filterByID', 'filterByName', 'order'));
    }


    public function employees(Request $request): View
    {
        $filterByID = $request->inputID ?? '';
        $filterByName = $request->inputName ?? '';
        $order = $request->order ?? '';

        $employeesQuery = User::query()->where('user_type', 'E');

        if ($filterByID !== '') {
            $employeesQuery = $employeesQuery->where('id', $filterByID);
        }

        if ($filterByName !== '') {
            $employeesQuery = $employeesQuery->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        if ($order !==''){
            switch ($order) {
                case 'ascID':
                    $employeesQuery = $employeesQuery->orderBy('id', 'asc');
                    break;
                case 'descID':
                    $employeesQuery = $employeesQuery->orderBy('id', 'desc');
                    break;
                case 'ascDate':
                    $employeesQuery = $employeesQuery->orderBy('created_at', 'asc');
                    break;
                case 'descDate':
                    $employeesQuery = $employeesQuery->orderBy('created_at', 'desc');
                    break;
                default:
                    $employeesQuery = $employeesQuery->orderBy('id', 'asc');
                    break;
            }
        }

        $employees = $employeesQuery->paginate(50);


        return view('dashboard.employees', compact('employees', 'filterByID', 'filterByName', 'order'));
    }

    public function admins(Request $request): View
    {
        $filterByID = $request->inputID ?? '';
        $filterByName = $request->inputName ?? '';
        $order = $request->order ?? '';

        $adminsQuery = User::query()->where('user_type', 'A');

        if ($filterByID !== '') {
            $adminsQuery = $adminsQuery->where('id', $filterByID);
        }

        if ($filterByName !== '') {
            $adminsQuery = $adminsQuery->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        if ($order !==''){
            switch ($order) {
                case 'ascID':
                    $adminsQuery = $adminsQuery->orderBy('id', 'asc');
                    break;
                case 'descID':
                    $adminsQuery = $adminsQuery->orderBy('id', 'desc');
                    break;
                case 'ascDate':
                    $adminsQuery = $adminsQuery->orderBy('created_at', 'asc');
                    break;
                case 'descDate':
                    $adminsQuery = $adminsQuery->orderBy('created_at', 'desc');
                    break;
                default:
                    $adminsQuery = $adminsQuery->orderBy('id', 'asc');
                    break;
            }
        }

        $admins = $adminsQuery->paginate(50);


        return view('dashboard.admins', compact('admins', 'filterByID', 'filterByName', 'order'));
    }

    public function showOrders(Request $request): View
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

    public function updateOrder(Request $request, Order $order): RedirectResponse
    {
        $order->status = $request->status;
        $order->save();

        return redirect()->back()
            ->with('alert-msg', "Order no. $order->id updated to \"$order->status\" successfully.")
            ->with('alert-type', 'success');
    }

    public function showDetails(Order $order): View
    {
        $user = User::where('id', $order->customer_id)->first();
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $customer = Customer::where('id', $order->customer_id)->first();

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

    public function deleteUser(User $user): RedirectResponse
    {
        // user auth() is not A (admin)
        if (auth()->user()->user_type !== 'A') {
            return redirect()->back()
                ->with('alert-msg', 'You are not authorized to delete users.')
                ->with('alert-type', 'danger');
        }

        $user->delete();

        return redirect()->back()
            ->with('alert-msg', "User no. $user->id deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function changeUserStatus(Request $request, User $user): RedirectResponse
    {
        $user->blocked = $request->blocked ? 1 : 0;
        $user->save();

        return redirect()->back()
            ->with('alert-msg', "User no. $user->id block status update successfully.")
            ->with('alert-type', 'success');
    }

    public function addEmployee(): View
    {
        return view('dashboard.addEmployee');
    }

    public function storeEmployee(AddAdminEmployee $request): RedirectResponse
    {
        $data = $request->validated();
        $employee = DB::transaction(function () use ($data, $request) {
            $employee = new User();
            $employee->name = $data['name'];
            $employee->email = $data['email'];
            $employee->password = Hash::make($data['password']);
            $employee->user_type = 'E';
            $employee->save();
        });


        return redirect()->back()
            ->with('alert-msg', "Employee added successfully.")
            ->with('alert-type', 'success');
    }

    public function addAdmin(): View
    {
        return view('dashboard.addAdmin');
    }

    public function storeAdmin(AddAdminEmployee $request): RedirectResponse
    {
        $data = $request->validated();
        $admin = DB::transaction(function () use ($data, $request) {
            $admin = new User();
            $admin->name = $data['name'];
            $admin->email = $data['email'];
            $admin->password = Hash::make($data['password']);
            $admin->user_type = 'A';
            $admin->save();
        });


        return redirect()->back()
            ->with('alert-msg', "Admin added successfully.")
            ->with('alert-type', 'success');
    }

    public function edit(User $user): View
    {
        return view('dashboard.edit', compact('user'));
    }

    public function deletePhoto(User $user): RedirectResponse
    {

        if ($user->photo_url) {
            Storage::delete('public/photos/' . $user->photo_url);
            $user->photo_url = null;
            $user->save();
        }

        return redirect()->back()
            ->with('alert-msg', "Photo deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function updateData(UpdateAdminEmployee $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($user->photo_url) {
                Storage::delete('public/photos/' . $user->photo_url);
            }

            $path = $request->file('image')->store('public/photos');
            $filename = basename($path);
            $user->photo_url = $filename;
        }

        $user->update($data);

        return redirect()->back()
            ->with('alert-msg', "User $user->name updated successfully.")
            ->with('alert-type', 'success');
    }

}
