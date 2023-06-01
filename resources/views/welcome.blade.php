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
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage1 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage1 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage1 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                            <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage2 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage2 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage2 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage3 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage3 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage3 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage4 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage4 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage4 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
        </div> <!-- row.// -->

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->



<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content">
    <div class="container">

        <header class="section-heading">
            <h3 class="section-title">New arrived</h3>
        </header><!-- sect-heading -->

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage5 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage5 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage5 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage6 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage6 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage6 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage7 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage7 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage7 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @foreach($tshirtImage8 as $tshirtImage)
                        <img src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                    @endforeach
                    <div class="card-body d-flex flex-column">
                        @foreach($tshirtImage8 as $tshirtImage)
                            <p>{{ $tshirtImage->name }}</p>
                        @endforeach
                        @foreach($tshirtImage8 as $tshirtImage)
                            <p>{{ $tshirtImage->description }}</p>
                        @endforeach
                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>

                </div>
            </div>
        </div> <!-- row.// -->

    </div> <!-- container .//  -->
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
                            <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore </p>
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
                <div class="col-md-4">
                    <figure  class="item-feature">
                        <span class="text-primary"><i class="fa fa-2x fa-landmark"></i></span>
                        <figcaption class="pt-3">
                            <h5 class="title">Creative Strategy</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            </p>
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div><!-- col // -->
                <div class="col-md-4">
                    <figure  class="item-feature">
                        <span class="text-primary"><i class="fa fa-2x fa-lock"></i></span>
                        <figcaption class="pt-3">
                            <h5 class="title">High secured </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            </p>
                        </figcaption>
                    </figure> <!-- iconbox // -->
                </div> <!-- col // -->
            </div>
        </article>

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION FEATURE END// ========================= -->


</body>
</html>

@endsection
