<!DOCTYPE html>
<html>

<head>
    <title> Imagine Shirt - Receipt Order no. {{ $order->id }} </title>
    <link rel="icon" href="{{ asset('assets/images/logos/imagineshirt.png') }}" type="image/x-icon" />
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 75px;
        height: 75px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
</style>

<body>
    <div class="head-title">
        <h1 class="text-center m-0 p-0">Receipt</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">{{ $order->id }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">{{ $order->date }}</span></p>
        </div>
        <div class="w-50 float-left logo mt-10">
            <img src="{{ asset('assets/images/logos/imagineshirt.png') }}">
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">From</th>
                <th class="w-50">To</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p>Address: ESTG - Escola Superior de Tecnologia e Gestão</p>
                        <p>Contact: +351 915 164 693</p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p>Name: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Address: {{ $customer->address }}</p>
                        <p>NIF: {{ $customer->nif }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">Payment Method</th>
                <th class="w-50">Shipping Method</th>
            </tr>
            <tr align="center">
                <td>{{ $customer->default_payment_type }}</td>
                <td>Free Shipping</td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                @if ($showImage)
                    <th class="w-20">Image</th>
                @endif
                <th class="w-20">Product Name</th>
                <th class="w-20">Color</th>
                <th class="w-20">Size</th>
                <th class="w-20">Price</th>
                <th class="w-20">Qty</th>
                <th class="w-20">Subtotal</th>
            </tr>
            @foreach ($orderItems as $orderItem)
                <tr align="center">
                    @if ($showImage)
                        <td style="background-color:rgba(120, 120, 120, 0.1)"><img src="
                            {{ route('getImage', $tshirts[$orderItem->id]['image_url']) }}"
                                alt="T-Shirt Image" class="img-fluid rounded-3" style="height: 75px;"></td>
                    @endif
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
                            <p>Order Total:</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>{{ $order->total_price }}€</p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</html>
