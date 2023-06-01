@extends('layouts.app')

@section('content')

<!-- ========================= SECTION INTRO ========================= -->
<section class="section-intro padding-y-sm">
    <div class="container">

        <div class="intro-banner-wrap">
            <img src="assets/images/banner.png" class="img-fluid rounded">
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
            @foreach($popularProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image_url }}" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <p>{{ $product->name }}</p>
                        <p>{{ $product->description }}</p>
                        <a href="#" class="btn btn-primary mt-auto">Add to Cart</a>
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
            @foreach($newArrivals as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image_url }}" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <p>{{ $product->name }}</p>
                        <p>{{ $product->description }}</p>
                        <a href="#" class="btn btn-primary mt-auto">Add to Cart</a>
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
<<<<<<< Updated upstream
                            <p>Get your products delivered quickly with our fast and efficient shipping service.</p>
=======
<<<<<<< HEAD
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
=======
                            <p>Get your products delivered quickly with our fast and efficient shipping service.</p>
>>>>>>> 0d3091c91f9c58f262954894187c3e4b803738c8
>>>>>>> Stashed changes
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
                <div class="col-md-4">
                    <figure class="item-feature">
                        <span class="text-primary"><i class="fa fa-2x fa-landmark"></i></span>
                        <figcaption class="pt-3">
                            <h5 class="title">Creative Strategy</h5>
<<<<<<< Updated upstream
                            <p>Experience innovative and creative strategies to meet your unique needs.</p>
=======
<<<<<<< HEAD
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
=======
                            <p>Experience innovative and creative strategies to meet your unique needs.</p>
>>>>>>> 0d3091c91f9c58f262954894187c3e4b803738c8
>>>>>>> Stashed changes
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
                <div class="col-md-4">
                    <figure class="item-feature">
                        <span class="text-primary"><i class="fa fa-2x fa-lock"></i></span>
                        <figcaption class="pt-3">
                            <h5 class="title">High security</h5>
<<<<<<< Updated upstream
                            <p>Rest assured knowing that your information and transactions are highly secured.</p>
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
=======
<<<<<<< HEAD
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
            </div><!-- row -->
=======
                            <p>Rest assured knowing that your information and transactions are highly secured.</p>
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
>>>>>>> Stashed changes
            </div>

            </figcaption>
                    </figure> <!-- iconbox // -->
                </div> <!-- col // -->
            </div>
>>>>>>> 0d3091c91f9c58f262954894187c3e4b803738c8
        </article>
    </div><!-- container .// -->
</section>
<!-- ========================= SECTION FEATURE END// ========================= -->

</body>
</html>
@endsection


