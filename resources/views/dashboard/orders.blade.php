@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-3 mt-0">Orders</h1>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Status</th>
            <th scope="col">Date</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                @if($order->status != "canceled" && $order->status != "closed")
                <th scope="row">{{ $order->id }}</th>
                <td>{{ $order->status }}</td>
                <td>{{ $order->date }}</td>
                <td>
                        <div class="d-inline-flex align-content-center">
                            <i class="bi bi-pencil ml-4 mr-3"></i>
                        </div>
                </td>
                @elseif(Auth::user()->user_type != 'E' && ($order->status == "canceled" || $order->status == "closed"))
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->date }}</td>
                        <td>
                        </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
