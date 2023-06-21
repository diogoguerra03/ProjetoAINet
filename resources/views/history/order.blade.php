@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')



@section('content')
    @foreach ($orders as $order)
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    @if (session('alert-msg'))
                        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                            {{ session('alert-msg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="h1 mb-2">Order no. {{ $order->id }}</p>
                                                </p>
                                            </div>
                                        </div>
                                        @forelse ($orderItems[$order->id] as $orderItem)
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div style="background-color:rgba(120, 120, 120, 0.1)">
                                                                <img src=" {{ route('getImage', $tshirts[$orderItem->id]['image_url']) }}"
                                                                    alt="T-Shirt Image" class="img-fluid rounded-3"
                                                                    style="height: 150px;">
                                                            </div>
                                                            <div class="ms-3">
                                                                <h3>{{ $tshirts[$orderItem->id]['name'] }}</h3>
                                                                <p class="h6">Color:
                                                                    {{ $colors[$orderItem->id] }}</p>
                                                                <p class="h6">Size: {{ $orderItem->size }}
                                                                </p>
                                                                <p class="h6">Unit. Price:
                                                                    {{ $orderItem->unit_price }}€</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div style="width: 50px;">
                                                                <h5 class="fw-normal mb-0">{{ $orderItem->qty }}</h5>
                                                            </div>
                                                            <div style="width: 80px;">
                                                                <h5 class="mb-0">{{ $orderItem->sub_total }}€
                                                                </h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12 text-center">
                                                <h1>There are no orders!</h1>
                                            </div>
                                        @endforelse

                                    </div>
                                    <div class="col-lg-5">
                                        <h3 class="mb-5">Order Resumed</h3>
                                        <div class="d-flex justify-content-between mt-5">
                                            <p class="h4 mb-2">Total (IVA included)</p>
                                            <p class="h4 mb-2">{{ $order->total_price }}€</p>
                                        </div>
                                        <div class="d-flex justify-content-between mt-5">
                                            <p class="h4 mb-2">Status:</p>
                                            <p class="h4 mb-2">{{ strtoupper($order->status) }}</p>
                                        </div>
                                        <hr class="my-4">
                                        @if ($order->status === 'closed')
                                            <a href="{{ route('receipt.view', $order->id) }}" target="_blank"
                                                class="btn btn-primary btn-lg">View
                                                Receipt</a>
                                            <a href="{{ route('receipt.download', $order->id) }}"
                                                class="btn btn-primary btn-lg">Download
                                                Receipt</a>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection
