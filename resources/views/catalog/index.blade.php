@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>T-Shirt Shop</h1>
        <div class="row">
            @foreach($allTshirtImages as $tshirtImage)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top tshirt-image" src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tshirtImage->name }}</h5>
                            <p class="card-text">{{ $tshirtImage->description }}</p>
                            <a href="#" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="pagination justify-content-center mt-5">
        {{ $allTshirtImages->links() }}
    </div>
@endsection