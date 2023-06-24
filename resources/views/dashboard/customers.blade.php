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
            const orderButtons = document.querySelectorAll('button[data-bs-target="#myModal"]');
            const popupTitle = document.getElementById('popupTitle');

            orderButtons.forEach(function(orderButton) {
                orderButton.addEventListener('click', function() {
                    const orderID = this.dataset.orderId;
                    popupTitle.innerText = 'Order ID: ' + orderID;
                    document.getElementById('statusInput').value = orderID;
                });
            });
        });
    </script>




    @if (session('alert-msg'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            {{ session('alert-msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="text-center mb-3 mt-0">Customers</h1>

    <hr>

    <!-- filtro -->
    <form method="GET" action="{{ route('dashboard.customers') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="col-md-3 mb-3">
                        <label for="inputID" class="form-label">Order ID</label>
                        <input type="text" class="form-control" name="inputID" id="inputID"
                               value="{{ old('inputID', $filterByID) }}" placeholder="Enter the ID">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="inputName" class="form-label">Customer ID</label>
                        <input type="text" class="form-control" name="inputName" id="inputName"
                               value="{{ old('inputName', $filterByName) }}" placeholder="Enter the name">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="order" class="form-label">Order</label>
                        <select class="form-select" name="order" id="order">
                            <option value="ascID" {{ old('order', $order) === 'ascID' ? 'selected' : '' }}>Ascending by ID</option>
                            <option value="descID" {{ old('order', $order) === 'descID' ? 'selected' : '' }}>Descending by ID</option>
                            <option value="ascDate" {{ old('order', $order) === 'ascDate' ? 'selected' : '' }}>Ascending by Creation Date</option>
                            <option value="descDate" {{ old('order', $order) === 'descDate' ? 'selected' : '' }}>Descending by Creation Date</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary mb-3 px-4 me-2 flex-grow-1 mx-auto" name="filtrar">Filter</button>
                        <a href="{{ route('dashboard.customers') }}" class="text-white btn btn-secondary mb-3 px-4 me-2 flex-grow-1 mx-auto"
                           style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                            <div>Clear</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- fim do filtro -->



    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Blocked</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('dashboard.user.block', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="blocked" value="{{ $user->blocked ? '0' : '1' }}">
                            <input type="checkbox" class="form-check-input ms-3" onchange="this.form.submit()"
                                {{ $user->blocked ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.user.delete', $user->id) }}" method="POST"
                            id="deleteForm_{{ $user->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2">
                                <i class="bi bi-trash "></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
