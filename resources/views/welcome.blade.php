@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@php
    $discountPercentage = round($discountPercentage);
@endphp

@section('content')
    <!-- ========================= SECTION INTRO ========================= -->
    <section class="section-intro padding-y-sm">
        <div class="container">
            @if (session('alert-msg'))
                <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                    {{ session('alert-msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="intro-banner-wrap">
                <div class="jumbotron jumbotron-fluid text-center"
                    style="background-image:url(assets/images/backgroundDiscount.png);">
                    <div class="container" style="background:">
                        <h1 class="display-4"
                            style="color:white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
                            PROMOÇÃO</h1>
                        <h5 class="lead"
                            style="font-size:40px; color:white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
                            {{ $discountPercentage }}% de desconto na
                            compra de
                            {{ $price['quantityForDiscount'] }} t-shirts</h5>
                    </div>
                </div>
            </div>

        </div> <!-- container //  -->
    </section>
    <!-- ========================= SECTION INTRO END// ========================= -->


    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <h3 class="section-title">Popular products</h3>
            </header><!-- sect-heading -->

            <div class="row">
                @foreach ($popularProducts as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="position-absolute top-0 start-0 bg-success text-white px-2 py-1">
                                <i class="fas fa-star mr-1"></i> Popular
                            </div>
                            <img class="card-img-top img-fluid mx-auto d-block image-container"
                                src="{{ asset('storage/tshirt_images/' . $product->image_url) }}" alt="Product Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }} - {{ $price['withoutDiscount'] }}€
                                </h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-primary mt-auto">View
                                    product</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!-- row.// -->
        </div><!-- container .// -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->


    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <h3 class="section-title">New arrivals</h3>
            </header><!-- sect-heading -->

            <div class="row">
                @foreach ($newArrivals as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1">
                                <i class="bi-exclamation-circle-fill mr-1"></i> New
                            </div>
                            <img class="card-img-top img-fluid mx-auto d-block image-container"
                                src="{{ asset('storage/tshirt_images/' . $product->image_url) }}" alt="Product Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }} - {{ $price['withoutDiscount'] }}€
                                </h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-primary mt-auto">View
                                    product</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!-- row.// -->
        </div><!-- container .// -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->


    <!-- ========================= SECTION FEATURE ========================= -->
    <section class="section-content padding-y-sm">
        <div class="container">
            <article class="card card-body">
                <div class="row">
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-truck"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Fast delivery</h5>
                                <p>Get your products delivered quickly with our fast and efficient shipping service.</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-landmark"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Creative Strategy</h5>
                                <p>Experience innovative and creative strategies to meet your unique needs.</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-lock"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">High security</h5>
                                <p>Rest assured knowing that your information and transactions are highly secured.</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                </div>
            </article>
        </div><!-- container .// -->
    </section>
    <!-- ========================= SECTION FEATURE END// ========================= -->

    </body>

    </html>
@endsection
