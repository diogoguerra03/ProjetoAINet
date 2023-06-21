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
                    <div class="col-md-4 mb-3">
                        <label for="inputStatus" class="form-label">Order Status</label>
                        <input type="text" class="form-control" name="status" id="inputStatus"
                            value="{{ old('status', $filterByStatus) }}" placeholder="Enter the order status">
                    </div>
                    {{-- <div class="col-md-4 mb-3">
                        <label for="inputStatus" class="form-label">Customer ID</label>
                        <input type="text" class="form-control" name="status" id="inputStatus"
                            value="{{ old('status', $filterByStatus) }}" placeholder="Enter the order status">
                    </div> --}}
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary mb-3 px-4 me-2 flex-grow-1"
                            name="filtrar">Filter</button>
                        <a href="{{ route('dashboard.orders') }}"
                            class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Clear</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- fim do filtro -->



    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
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
            @foreach ($orders as $order)
                <tr>
                    @if ($order->status != 'canceled' && $order->status != 'closed')
                        <th scope="row">{{ $order->id }}</th>
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
                                    @if (Auth::user()->user_type === 'E')
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
                                    @elseif(Auth::user()->user_type === 'A')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-success mb-2">
                                                Order paid
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-success mb-2">
                                                Order paid
                                            </button>
                                        </form>
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

                        <td>
                            <div class="row">
                                <div class="col">
                                    @if (Auth::user()->user_type === 'A')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-danger mb-2">
                                                Cancel order
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </td>
                    @elseif(Auth::user()->user_type === 'A' && ($order->status == 'canceled' || $order->status == 'closed'))
                        <th scope="row">{{ $order->id }}</th>
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
                                    @if ($order->status == 'closed')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="canceled">
                                            <button type="submit" class="btn btn-danger mb-2">
                                                Cancel order
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
