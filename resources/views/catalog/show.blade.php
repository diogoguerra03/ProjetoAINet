@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('alert-msg'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                {{ session('alert-msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="zoom imagesParent carousel-item active">
                            <img src='/storage/tshirt_base/fafafa.jpg' alt="" class="image-container d-block w-100"
                                id="tshirt">

                            <img src="{{ route('photo', $catalog) }}" alt="{{ $catalog->name }}"
                                class="image-container d-block w-100 h-25" id="tshirtImage">

                        </div>
                        <div class="zoom carousel-item">
                            <img class="image-container d-block w-100" src="{{ route('photo', $catalog) }}"
                                alt="{{ $catalog->name }}">

                        </div>
                    </div>

                    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" data-dismiss="modal">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <img src="" class="imagepreview" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="tshirtId" value="{{ $catalog->id }}">
                    <input type="hidden" name="tshirtName" value="{{ $catalog->name }}">
                    <input type="hidden" name="tshirtUrl" value="{{ $catalog->image_url }}">
                    <h1>{{ $catalog->name }}</h1>
                    @if ($catalog->customer_id)
                        <h2><b>{{ $price->first()->unit_price_own }} € </b></h2>
                    @else
                        <h2><b>{{ $price->first()->unit_price_catalog }} € </b></h2>
                    @endif
                    <section class="mt-4 mb-3">
                        <h4>Description</h4>
                        <p>{{ $catalog->description }}</p>
                    </section>

                    <div class="form-group">
                        <div class="sizes mt-5">
                            <h6 class="text-uppercase">Size</h6>
                            <label class="radio">
                                <input type="radio" name="size" value="XS" checked>
                                <span>XS</span> </label>
                            <label class="radio"> <input type="radio" name="size" value="S">
                                <span>S</span>
                            </label>
                            <label class="radio"> <input type="radio" name="size" value="M">
                                <span>M</span>
                            </label>
                            <label class="radio"> <input type="radio" name="size" value="L">
                                <span>L</span>
                            </label>
                            <label class="radio"> <input type="radio" name="size" value="XL">
                                <span>XL</span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group d-flex">
                        @php
                            $colorsCount = $colors->count();
                            $halfColorsCount = ceil($colorsCount / 2);
                        @endphp

                        @foreach ($colors->take($halfColorsCount) as $colorCode => $colorName)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input color-option" type="radio" name="color"
                                    id="{{ $colorCode }}" value="{{ $colorCode }}"
                                    style="background-color: #{{ $colorCode }};">
                            </div>
                        @endforeach
                    </div>

                    <!-- Quebra de linha -->

                    <div class="form-group d-flex mb-5">
                        @foreach ($colors->skip($halfColorsCount) as $colorCode => $colorName)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input color-option" type="radio" name="color"
                                    id="{{ $colorCode }}" value="{{ $colorCode }}"
                                    style="background-color: #{{ $colorCode }};">
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <div class="quantity-input d-flex">
                            <button type="submit" name="addToCart" class="btn btn-primary ml-2 mr-5">Add to
                                cart</button>
                            <button type="button" class="btn btn-sm btn-secondary quantity-btn ml-5"
                                data-action="decrement">-</button>
                            <input type="number" class="form-control quantity" name="quantity" min="1"
                                max="99" value="1">
                            <button type="button" class="btn btn-sm btn-secondary quantity-btn"
                                data-action="increment">+</button>
                        </div>
                    </div>
                @endsection
