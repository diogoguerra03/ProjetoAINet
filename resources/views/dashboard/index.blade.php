@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <!-- ========================= CARDS ========================= -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card h-100 bg-info text-white">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text">{{$totalProducts}}</p>
                    <hr>
                    <a href="" class="btn btn-light mt-auto">More info</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 bg-success text-white">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Orders placed</h5>
                    <p class="card-text">{{$ordersPlaced}}</p>
                    <hr>
                    <a href="" class="btn btn-light mt-auto">More info</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 bg-danger text-white">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Money Earned</h5>
                    <p class="card-text">{{$moneyEarned}}€</p>
                    <hr>
                    <a href="" class="btn btn-light mt-auto">More info</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 bg-warning text-white">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Customers registered</h5>
                    <p class="card-text">{{$numberCustomers}}</p>
                    <hr>
                    <a href="{{ route('dashboard.customers') }}" class="btn btn-light mt-auto">More info</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================= GRAPHS ========================= -->
    <div class="row">
        <div class="col-md-7">
            <div class="card pb-5">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card pb-1">
                <canvas id="pieChart" width="200" height="200"></canvas>
            </div>
    </div>
    </div>





    </div>
    </div>
    </div>






    @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
    @endsection



@endsection
