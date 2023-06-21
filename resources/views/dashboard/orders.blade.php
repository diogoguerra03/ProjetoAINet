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
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
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
                                        @method('PUT')
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
                                            <button type="submit" class="btn btn-success mb-2">
                                                Declare paid
                                            </button>
                                        </form>
                                    @elseif($order->status == 'paid')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning mb-2">
                                                Declare closed
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    @elseif(Auth::user()->user_type != 'E' && ($order->status == 'canceled' || $order->status == 'closed'))
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('PUT')
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
                                            <button type="submit" class="btn btn-success mb-2">
                                                Declare paid
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
