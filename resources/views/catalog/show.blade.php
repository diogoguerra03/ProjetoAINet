@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $tshirtImage->image_url }}" alt="{{ $tshirtImage->name }}" class="image-container">
            </div>
            <div class="col-md-6">
                <h1>{{ $tshirtImage->name }}</h1>
                <p>{{ $tshirtImage->description }}</p>
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="size">Size:</label>
                        <select name="size" id="size" class="form-control">
                            <option value="S">Small</option>
                            <option value="M">Medium</option>
                            <option value="L">Large</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <select name="color" id="color" class="form-control">
                            <option value="Red">Red</option>
                            <option value="Blue">Blue</option>
                            <option value="Green">Green</option>
                        </select>
                    </div>
                    <form action="{{ route('cart.store') }}" mehod="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $tshirtImage->id }}"
                        <input type="number" value="1" name="quantity" class="form-control w-25 d-inline">
                        <button type="submit" name="store" class="btn btn-primary ml-2">
                            Add to cart</button>
                    </form>
                </form>
            </div>
        </div>
    </div>
@endsection
