@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>T-Shirt Shop</h1>
        
        <div class="row">
            <div class="col-md-12 mb-4">
                <form action="{{ route('filter') }}" method="GET">
                    <div class="form-group">
                        <label for="category">Select Category:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $selectedCategoryId) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
        
        <div class="row">
            @forelse($allTshirtImages as $tshirtImage)
                <div class="col-md-4">
                    <div class="card h-100">
                        <img class="card-img-top tshirt-image img-fluid mx-auto d-block" src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $tshirtImage->name }}</h5>
                            <p class="card-text">{{ $tshirtImage->description }}</p>
                            <a href="#" class="btn btn-primary mt-auto">Add to Cart</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>No t-shirt images found.</p>
                </div>
            @endforelse
        </div>
        
    <div class="pagination justify-content-center mt-5">
        {{ $allTshirtImages->links() }}
    </div>
@endsection 