@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')



@section('content')
    @php
        $subtotal = 0; // Initialize the subtotal variable
    @endphp

    <section class="h-100 h-custom" style="background-color: #eee;">
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
                                            <p class="h1 mb-1">Shopping cart</p>
                                            <p class="h4 mb-0">You have {{ count(session('cart', [])) }} items in your cart
                                            </p>
                                        </div>
                                    </div>
                                    @forelse ($cart as $index => $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div>
                                                            <img src="{{ $item['tshirt_image'] }}" alt="T-Shirt Image"
                                                                class="img-fluid rounded-3" style="height: 150px;">
                                                        </div>
                                                        <div class="ms-3">
                                                            <h2>{{ $item['product_name'] }}</h2>
                                                            <p class="h5">Color: {{ $item['color'] }}</p>
                                                            <p class="h5">Size: {{ $item['size'] }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div style="width: 50px;">
                                                            <h5 class="fw-normal mb-0">{{ $item['quantity'] }}</h5>
                                                        </div>
                                                        <div style="width: 80px;">
                                                            <h5 class="mb-0">{{ $item['price'] }}€</h5>
                                                            @php
                                                                $subtotal += $item['price']; // adicionar os valores das tshirts
                                                            @endphp

                                                        </div>
                                                        <form action="{{ route('cart.remove', $index) }}" method="POST"
                                                            id="deleteFromCart_{{ $item['product_id'] }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link"
                                                                style="color: #cecece;">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <div class="col-md-12 text-center">
                                                <h1>Cart is empty!</h1>
                                            </div>
                                        @endforelse

                                    </div>
                                    <div class="col-lg-5">
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between">
                                            <p class="h3 mb-2">Total (IVA included)</p>
                                            <p class="h3 mb-2">{{ $subtotal }}€</p>
                                        </div>
                                        <button type="button" class="btn btn-info btn-block btn-lg">
                                            <div class="d-flex">
                                                <span>Checkout <i class="fas ms-2 h1"></i></span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @csrf
        @method('DELETE')
        </form>
    @endsection
