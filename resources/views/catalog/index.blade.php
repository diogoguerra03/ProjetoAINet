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
                                @if ($user !== null && $user->user_type === 'C')
                                    <option {{ old('category', $filterByCategory) === 'my_products' ? 'selected' : '' }}
                                        value="my_products">My products</option>
                                @endif


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
                            <option {{ old('orderBy', $orderBy) === 'popular_products' ? 'selected' : '' }}
                                value="popular_products">Popular products
                            </option>
                            <option {{ old('orderBy', $orderBy) === 'new_arrivals' ? 'selected' : '' }}
                                value="new_arrivals">New arrivals
                            </option>
                            <option {{ old('orderBy', $orderBy) === 'older_arrivals' ? 'selected' : '' }}
                                value="older_arrivals">Older products
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
            @forelse($tshirtImages as $index => $tshirtImage)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('catalog.show', $tshirtImage->slug) }}">
                            @if ($index < 3 && $orderBy === 'popular_products')
                                <div class="position-absolute top-0 start-0 bg-success text-white px-2 py-1">
                                    <i class="fas fa-star mr-1"></i> Popular
                                </div>
                            @endif

                            @if ($index < 3 && $orderBy === 'new_arrivals')
                                <div class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1">
                                    <i class="bi-exclamation-circle-fill mr-1"></i> New
                                </div>
                            @endif

                            @if ($user !== null && $tshirtImage->customer_id === $user->id)
                                <img class="card-img-top img-fluid mx-auto d-block image-container"
                                    src="{{ route('photo', ['path' => $tshirtImage->image_url]) }}" alt="T-Shirt Image">
                            @else
                                <img class="card-img-top img-fluid mx-auto d-block image-container"
                                    src="{{ $tshirtImage->image_url }}" alt="T-Shirt Image">
                            @endif

                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $tshirtImage->name }} - {{ $prices->first()->unit_price_catalog }} €
                            </h5>
                            <p class="card-text">{{ $tshirtImage->description }}</p>
                            <a href="{{ route('catalog.show', $tshirtImage->slug) }}" class="btn btn-primary mt-auto">View
                                product</a>

                            <div class="mt-3 d-flex">
                                @can('update', $tshirtImage)
                                    <a href="{{ route('catalog.edit', $tshirtImage->slug) }}"
                                        class="btn btn-success flex-fill mr-1">Edit</a>
                                @endcan
                                @can('delete', $tshirtImage)
                                    <div class="flex-fill ml-1">
                                        <form method="POST" action="{{ route('catalog.destroy', $tshirtImage->slug) }}"
                                            id="deleteForm_{{ $tshirtImage->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger flex-fill w-100">Delete</button>
                                        </form>
                                    </div>
                                @endcan
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
            {{ $tshirtImages->withQueryString()->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
