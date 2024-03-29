@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    @if (session('alert-msg'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            {{ session('alert-msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="text-center mb-3 mt-0">Orders</h1>
    <hr>
    <form method="GET" action="{{ route('dashboard.orders') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="col-md-3 mb-3">
                        <label for="inputOrderID" class="form-label">Order ID</label>
                        <input type="text" class="form-control" name="order_id" id="inputOrderID"
                            value="{{ old('order_id', $filterByOrderID) }}" placeholder="Enter the order ID">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="inputCustID" class="form-label">Customer ID</label>
                        <input type="text" class="form-control" name="customer_id" id="inputCustID"
                            value="{{ old('customer_id', $filterByCustID) }}" placeholder="Enter the customer ID">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="inputStatus" class="form-label">Order Status</label>
                        <select class="form-select" name="status" id="inputStatus">
                            <option {{ old('status', $filterByStatus) === '' ? 'selected' : '' }} value="">All states
                            </option>
                            <option {{ old('status', $filterByStatus) === 'pending' ? 'selected' : '' }} value="pending">
                                Pending</option>
                            <option {{ old('status', $filterByStatus) === 'paid' ? 'selected' : '' }} value="paid">Paid
                            </option>
                            @if (Auth::user()->user_type === 'A')
                                <option {{ old('status', $filterByStatus) === 'closed' ? 'selected' : '' }} value="closed">
                                    Closed</option>
                                <option {{ old('status', $filterByStatus) === 'canceled' ? 'selected' : '' }}
                                    value="canceled">
                                    Canceled</option>
                            @endif
                        </select>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary mb-3 px-4 me-2 flex-grow-1 mx-auto"
                            name="filtrar">Filter</button>
                        <a href="{{ route('dashboard.orders') }}"
                            class="text-white btn btn-secondary mb-3 px-4 me-2 flex-grow-1 mx-auto"
                            style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                            <div>Clear</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- fim do filtro -->

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Customer ID</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                @if (Auth::user()->user_type === 'A')
                    <th scope="col"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if (Auth::user()->user_type === 'A')
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <th scope="row">{{ $order->customer_id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Check details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->total_price }}€</td>
                        <td>{{ strtoupper($order->status) }}</td>
                        <td></td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="status" class="btn btn-primary mb-2" value="pending"
                                            {{ $order->status === 'pending' ? 'disabled' : '' }}>
                                            Pending
                                        </button>
                                        <button type="submit" name="status" class="btn btn-success mb-2" value="paid"
                                            {{ $order->status === 'paid' ? 'disabled' : '' }}>
                                            Paid
                                        </button>
                                        <button type="submit" name="status" class="btn btn-warning mb-2" value="closed"
                                            {{ $order->status === 'closed' ? 'disabled' : '' }}>
                                            Closed
                                        </button>
                                        <button type="submit" name="status" class="btn btn-danger mb-2" value="canceled"
                                            {{ $order->status === 'canceled' ? 'disabled' : '' }}>
                                            Canceled
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @else
                @foreach ($ordersPendingOrPaid as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <th scope="row">{{ $order->customer_id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Check details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->total_price }}€</td>
                        <td>{{ strtoupper($order->status) }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    @if ($order->status == 'pending')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-success mb-2">
                                                Order paid
                                            </button>
                                        </form>
                                    @elseif($order->status == 'paid')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="closed">
                                            <button type="submit" class="btn btn-warning mb-2">
                                                Order closed
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if (Auth::user()->user_type === 'A')
        <div class="justify-content-center mt-5 ">
            {{ $orders->withQueryString()->links() }}
        </div>
    @else
        <div class="justify-content-center mt-5 ">
            {{ $ordersPendingOrPaid->withQueryString()->links() }}
    @endif
@endsection
