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


    @if(request()->path() === 'dashboard/customers' )
        <form method="GET" action="{{ route('dashboard.customers') }}">
    @elseif(request()->path() === 'dashboard/employees' )
        <form method="GET" action="{{ route('dashboard.employees') }}">
    @else
        <form method="GET" action="{{ route('dashboard.admins') }}">
    @endif
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
                    @if(request()->path() === 'dashboard/customers' )
                        <a href="{{ route('dashboard.customers') }}" class="text-white btn btn-secondary mb-3 px-4 me-2 flex-grow-1 mx-auto" style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                    @elseif(request()->path() === 'dashboard/employees' )
                        <a href="{{ route('dashboard.employees') }}" class="text-white btn btn-secondary mb-3 px-4 me-2 flex-grow-1 mx-auto" style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                    @else
                        <a href="{{ route('dashboard.admins') }}" class="text-white btn btn-secondary mb-3 px-4 me-2 flex-grow-1 mx-auto" style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                    @endif
                        <div>Clear</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

