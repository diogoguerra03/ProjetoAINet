@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')


@section('content')
    <form style="margin:5%">
        <div style="margin-bottom:20px">
            <a href="{{ route('dashboard.orders') }}" class="btn btn-primary">Go back</a>
        </div>
        <h3> Order no. {{ $order->id }} details</h3>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Customer name</label>
                <input type="email" class="form-control" id="inputEmail4" value="{{ $user->name }}" readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">E-mail</label>
                <input type="email" class="form-control" id="inputPassword4" value="{{ $user->email }}" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="inputCity">Customer id</label>
                <input type="text" class="form-control" id="inputCity" value="{{ strtoupper($user->id) }}" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="inputCity">NIF</label>
                <input type="text" class="form-control" id="inputCity" value="{{ strtoupper($order->nif) }}" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="inputCity">Order status</label>
                <input type="text" class="form-control" id="inputCity" value="{{ strtoupper($order->status) }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Order date</label>
                <input type="text" class="form-control" id="inputCity" value="{{ $order->date }}" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Order total price</label>
                <input type="text" class="form-control" id="inputCity" value="{{ $order->total_price }}€" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Costumer address</label>
                <input type="text" class="form-control" id="inputCity" value="{{ $order->address }}" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Payment type</label>
                <input type="text" class="form-control" id="inputCity" value="{{ $order->payment_type }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Payment reference</label>
                <input type="text" class="form-control" id="inputCity" value="{{ $order->payment_ref }}" readonly>
            </div>
        </div>


        <div class="table-section bill-tbl w-100 mt-10">
            <h4> Order products: </h4>
            <table class="table w-100 mt-10">
                <tr align="center">
                    <th class="w-20">Image</th>
                    <th class="w-20">Product Name</th>
                    <th class="w-20">Color</th>
                    <th class="w-20">Size</th>
                    <th class="w-20">Price</th>
                    <th class="w-20">Qty</th>
                    <th class="w-20">Subtotal</th>
                </tr>
                @foreach ($orderItems as $orderItem)
                    <tr align="center">
                        <td style="background-color:lightcyan"><img
                                src=" {{ route('getImage', $tshirts[$orderItem->id]['image_url']) }}" alt="T-Shirt Image"
                                class="img-fluid rounded-3" style="height: 75px;"></td>
                        <td>{{ $tshirts[$orderItem->id]['name'] }}</td>
                        <td>{{ $colors[$orderItem->id] }}</td>
                        <td>{{ $orderItem->size }}</td>
                        <td>{{ $orderItem->unit_price }}€</td>
                        <td>{{ $orderItem->qty }}</td>
                        <td>{{ $orderItem->sub_total }}€</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7">
                        <div class="total-part">
                            <div class="total-left w-85 float-left" align="right">
                                <h5>Order Total: {{ $order->total_price }}€</h5>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-group">
            <label for="inputAddress2">Order notes</label>
            <input type="text" class="form-control" id="inputAddress2" value="{{ $order->notes }}" readonly>
        </div>

        <div style="margin-top:20px">
            <a href="{{ route('dashboard.orders') }}" class="btn btn-primary">Go back</a>
        </div>
    </form>
@endsection
