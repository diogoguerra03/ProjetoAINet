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
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-7">


                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class="mb-1">Carrinho de compras</p>
                                            <p class="mb-0">You have 4 items in your cart</p>
                                        </div>
                                    </div>


                                    @foreach ($cart as $item)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div>
                                                            <img src="{{ $item['tshirt_image'] }}" alt="T-Shirt Image"
                                                                class="img-fluid rounded-3" style="width: 150px;">
                                                        </div>
                                                        <div class="ms-3">
                                                            <h2>Iphone 11 pro</h2>
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
                                                        <a href="#!" style="color: #cecece;"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="col-lg-5">

                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between">
                                        <p class="h3 mb-2">Total (IVA incluído)</p>
                                        <p class="h3 mb-2">{{$subtotal}}€</p>
                                    </div>

                                    <button type="button" class="btn btn-info btn-block btn-lg">
                                        <div class="d-flex justify-content-between">
                                            <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
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


    <div class="my-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="ok" form="formStore">Confirmar Compra</button>
        <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">Limpar Carrinho</button>
    </div>
    {{-- <form id="formStore" method="POST" action="{{ route('cart.store') }}" class="d-none">
        @csrf
    </form>
    <form id="formClear" method="POST" action="{{ route('cart.destroy') }}" class="d-none"> --}}
    @csrf
    @method('DELETE')
    </form>
@endsection
