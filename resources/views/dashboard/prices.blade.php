@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <form action="{{ route('dashboard.updatePrices') }}" method="POST">
        @csrf
        @if (session('alert-msg'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                {{ session('alert-msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="text-center mb-3 mt-0">Prices</h1>
        <div class="form-row" style="margin: 5%;">
            <div class="col-6">
                <label for="inputZip" style="font-size: 1.2em;">Catalog price</label>
                <input type="text" class="form-control form-control-lg" name="unit_price_catalog"
                    value="{{ $price->unit_price_catalog }}">
            </div>
            <div class="col-6">
                <label for="inputZip" style="font-size: 1.2em;">Catalog price with discount</label>
                <input type="text" class="form-control form-control-lg" name="unit_price_catalog_discount"
                    value="{{ $price->unit_price_catalog_discount }}">
            </div>
        </div>
        <div class="form-row" style="margin: 5%;">
            <div class="col-6">
                <label for="inputZip" style="font-size: 1.2em;">Own t-shirt price</label>
                <input type="text" class="form-control form-control-lg" name="unit_price_own"
                    value="{{ $price->unit_price_own }}">
            </div>
            <div class="col-6">
                <label for="inputZip" style="font-size: 1.2em;">Own t-shirt price with discount</label>
                <input type="text" class="form-control form-control-lg" name="unit_price_own_discount"
                    value="{{ $price->unit_price_own_discount }}">
            </div>
        </div>
        <div class="form-row" style="margin: 5%;">
            <div class="col-6">
                <label for="inputZip" style="font-size: 1.2em;">Number of t-shirts to apply discount</label>
                <input type="text" class="form-control form-control-lg" name="qty_discount"
                    value="{{ $price->qty_discount }}">
            </div>
        </div>
        <div class="form-row" style="margin: 0% 15% 5% 15%;">
            <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                <span>Update Prices <i class="fas ms-2 h1"></i></span>
            </button>
        </div>
    </form>
@endsection

