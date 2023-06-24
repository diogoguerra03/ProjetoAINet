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
                                @can('viewMyProducts', \App\Models\TshirtImage::class)
                                    <option {{ old('category', $filterByCategory) === 'my_products' ? 'selected' : '' }}
                                        value="my_products">My products</option>
                                @endcan
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

        @can('create', $user)
            <div class="mb-4">
                <div class=" text-center">
                    <a href="{{ route('catalog.tshirt.create') }}" class="btn btn-primary">Create New Tshirt</a>
                </div>
            </div>
        @endcan

        @if (isset($user) && $user->user_type === 'A')
            @include('tshirts.shared.table', ['allowEdit' => true])
        @else
            @include('tshirts.shared.table', ['allowEdit' => false])
        @endif

        <div class="justify-content-center mt-5 ">
            {{ $tshirts->withQueryString()->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
