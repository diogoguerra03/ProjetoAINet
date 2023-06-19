@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')



@section('content')
    <h1>Order History</h1>

    @foreach ($orders as $order)
        <div>
            <h2>Order ID: {{ $order->id }}</h2>
            <!-- Display other order details as needed -->
        </div>
    @endforeach
@endsection
