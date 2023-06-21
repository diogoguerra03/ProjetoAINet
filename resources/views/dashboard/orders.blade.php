@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('button[data-status]').click(function() {
                var status = $(this).data('status');
                $('#statusInput').val(status);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const orderButton = document.querySelector('button[data-bs-target="#myModal"]');
            const popupTitle = document.getElementById('popupTitle');

            orderButton.addEventListener('click', function() {
                const orderID = this.dataset.orderId;
                popupTitle.innerText = 'Order ID: ' + orderID;
                document.getElementById('statusInput').value = orderID;
            });
        });
    </script>


    @if (session('alert-msg'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            {{ session('alert-msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="text-center mb-3 mt-0">Orders</h1>
    <hr>
    <form method="GET" action="{{ route('dashboard.orders') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="col-md-3 mb-3">
                        <label for="inputOrderID" class="form-label">Order ID</label>
                        <input type="text" class="form-control" name="order_id" id="inputOrderID"
                            value="{{ old('order_id', $filterByOrderID) }}" placeholder="Enter the order ID">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="inputCustID" class="form-label">Customer ID</label>
                        <input type="text" class="form-control" name="customer_id" id="inputCustID"
                            value="{{ old('customer_id', $filterByCustID) }}" placeholder="Enter the customer ID">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="inputStatus" class="form-label">Order Status</label>
                        <select class="form-select" name="status" id="inputStatus">
                            <option {{ old('status', $filterByStatus) === '' ? 'selected' : '' }} value="">All states
                            </option>
                            <option {{ old('status', $filterByStatus) === 'pending' ? 'selected' : '' }} value="pending">
                                Pending</option>
                            <option {{ old('status', $filterByStatus) === 'paid' ? 'selected' : '' }} value="paid">Paid
                            </option>
                            @if (Auth::user()->user_type === 'A')
                                <option {{ old('status', $filterByStatus) === 'closed' ? 'selected' : '' }} value="closed">
                                    Closed</option>
                                <option {{ old('status', $filterByStatus) === 'canceled' ? 'selected' : '' }}
                                    value="canceled">
                                    Canceled</option>
                            @endif
                        </select>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary mb-3 px-4 me-2 flex-grow-1 mx-auto"
                            name="filtrar">Filter</button>
                        <a class="btn btn-secondary mb-3 px-4 me-2 flex-grow-1 mx-auto"
                            href="{{ route('dashboard.orders') }}" class="text-white"
                            style="text-decoration: none">Clear</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- fim do filtro -->



    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Customer ID</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                @if (Auth::user()->user_type === 'A')
                    <th scope="col"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    @if ($order->status != 'canceled' && $order->status != 'closed')
                        <th scope="row">{{ $order->id }}</th>
                        <th scope="row">{{ $order->customer_id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Check details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->total_price }}€</td>
                        <td>{{ strtoupper($order->status) }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    @if (Auth::user()->user_type === 'E')
                                        @if ($order->status == 'pending')
                                            <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="paid">
                                                <button type="submit" class="btn btn-success mb-2">
                                                    Order paid
                                                </button>
                                            </form>
                                        @elseif($order->status == 'paid')
                                            <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="closed">
                                                <button type="submit" class="btn btn-warning mb-2">
                                                    Order closed
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    @if (Auth::user()->user_type === 'A')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal"
                                                data-bs-target="#myModal" data-order-id="{{ $order->id }}">
                                                Edit order status
                                            </button>
                                            <div class="modal fade" id="myModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="popupTitle"> </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Edit order status to: </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('dashboard.orders.update', $order) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <input type="hidden" name="status" id="statusInput"
                                                                    value="">
                                                                <button type="submit" class="btn btn-primary mb-2"
                                                                    data-status="pending">
                                                                    Pending
                                                                </button>
                                                                <button type="submit" class="btn btn-success mb-2"
                                                                    data-status="paid">
                                                                    Paid
                                                                </button>
                                                                <button type="submit" class="btn btn-warning mb-2"
                                                                    data-status="closed">
                                                                    Closed
                                                                </button>
                                                                <button type="submit" class="btn btn-danger mb-2"
                                                                    data-status="canceled">
                                                                    Canceled
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    @elseif(Auth::user()->user_type === 'A' && ($order->status == 'canceled' || $order->status == 'closed'))
                        <th scope="row">{{ $order->id }}</th>
                        <th scope="row">{{ $order->customer_id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Check details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->total_price }}€</td>
                        <td>{{ strtoupper($order->status) }}</td>
                        <td></td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-order-id="{{ $order->id }}">
                                            Edit order status
                                        </button>
                                        <div class="modal fade" id="myModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="popupTitle"> </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Edit order status to: </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('dashboard.orders.update', $order) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <input type="hidden" name="status" id="statusInput"
                                                                value="">
                                                            <button type="submit" class="btn btn-primary mb-2"
                                                                data-status="pending">
                                                                Pending
                                                            </button>
                                                            <button type="submit" class="btn btn-success mb-2"
                                                                data-status="paid">
                                                                Paid
                                                            </button>
                                                            <button type="submit" class="btn btn-warning mb-2"
                                                                data-status="closed">
                                                                Closed
                                                            </button>
                                                            <button type="submit" class="btn btn-danger mb-2"
                                                                data-status="canceled">
                                                                Canceled
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
