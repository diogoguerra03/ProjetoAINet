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
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="colorDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="selectedColor">Select Color</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="colorDropdown"
                                style="max-height: 200px; overflow-y: auto;">
                                @foreach ($colors as $colorCode => $colorName)
                                    <span class="dropdown-item color-option" data-color="{{ $colorCode }}">
                                        <i class="bi bi-circle-fill mr-2" style="color: #{{ $colorCode }}"></i>
                                        {{ $colorName }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="quantity-input d-flex align-items-center">
                            <form method="POST" action="{{ route('cart.add', ['orderItem' => $tshirtImage]) }}">
                                @csrf
                                <button type="submit" name="addToCart" class="btn btn-primary ml-2">
                                    Add to cart</button>
                                <button type="button" class="btn btn-sm btn-secondary quantity-btn"
                                    data-action="decrement">-</button>
                                <input type="number" class="form-control quantity" name="quantity" min="1"
                                    max="99" value="1">
                                <button type="button" class="btn btn-sm btn-secondary quantity-btn"
                                    data-action="increment">+</button>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@endsection
