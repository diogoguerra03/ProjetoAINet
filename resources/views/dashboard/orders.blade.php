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
                <th scope="row">{{ $order->id }}</th>
                <td>{{ $order->status }}</td>
                <td>{{ $order->date }}</td>
                <td>
                @if ($order->status != "closed" && $order->status != "cancelled")
                        <div class="d-inline-flex align-content-center">
                            <i class="bi bi-pencil ml-4 mr-3"></i>
                        </div>
                @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
