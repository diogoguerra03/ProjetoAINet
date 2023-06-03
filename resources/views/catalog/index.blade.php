@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="GET" action="{{ route('catalog.index') }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="inputCategory" class="form-label">Category</label>
                            <select class="form-select" name="category" id="inputCategory">
                                <option {{ old('category', $filterByCategory) === '' ? 'selected' : '' }} value="">
                                    All categories</option>
                                @foreach ($categories as $category)
                                    <option {{ old('category', $filterByCategory) == $category->id ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputNome" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" id="inputNome"
                                value="{{ old('name', $filterByName) }}" placeholder="Enter the product name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputDescricao" class="form-label">Product Description</label>
                            <input type="text" class="form-control" name="description" id="inputDescricao"
                                value="{{ old('description', $filterByDescription) }}"
                                placeholder="Enter the product description">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="inputOrderBy" class="form-label">Order By</label>
                        <select class="form-select" name="orderBy" id="inputOrderBy">
                            <option {{ old('orderBy', $orderBy) === 'popular_products' ? 'selected' : '' }} value="popular_products">Popular products
                            </option>
                            <option {{ old('orderBy', $orderBy) === 'new_arrivals' ? 'selected' : '' }} value="new_arrivals">New arrivals
                            </option>
                            <option {{ old('orderBy', $orderBy) === 'older_arrivals' ? 'selected' : '' }} value="older_arrivals">Older products
                            </option>
                            <option {{ old('orderBy', $orderBy) === 'name_asc' ? 'selected' : '' }} value="name_asc">Name
                                (Ascending)</option>
                            <option {{ old('orderBy', $orderBy) === 'name_desc' ? 'selected' : '' }} value="name_desc">Name
                                (Descending)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary me-3">Filter</button>
                <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Clean</a>
            </div>
        </form>


        <div class="row mt-5">
            @forelse($tshirtImages as $tshirtImage)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top img-fluid mx-auto d-block image-container"
                            src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $tshirtImage->name }} - {{ $prices->first()->unit_price_catalog }} €</h5>
                            <p class="card-text">{{ $tshirtImage->description }}</p>
                            <div class="quantity-input d-flex align-items-center mt-3">
                                <button type="button" class="btn btn-sm btn-secondary quantity-btn"
                                    data-action="decrement">-</button>
                                <input type="number" class="form-control quantity" name="quantity" min="1"
                                    max="99" value="1">
                                <button type="button" class="btn btn-sm btn-secondary quantity-btn"
                                    data-action="increment">+</button>
                                <button type="button" class="btn btn-primary ml-2">Add to Cart</button>

                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>No tshirt image found.</p>
                </div>
            @endforelse
        </div>

        <div class="justify-content-center mt-5 ">
            {{ $tshirtImages->links() }}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
