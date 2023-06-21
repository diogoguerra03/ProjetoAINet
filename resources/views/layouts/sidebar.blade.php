<!-- apenas mostra a sidebar se for admin -->
@if (Auth::user()->user_type === 'A')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-2 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <h1 class="fs-2 my-3">Dashboard</h1>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link align-middle px-0 ">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span></a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.orders') }}" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.admins') }}" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-server"></i> <span
                                    class="ms-1 d-none d-sm-inline">Administrators</span></a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.employees') }}" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-briefcase"></i> <span
                                    class="ms-1 d-none d-sm-inline">Employees</span></a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.customers') }}" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-people"></i> <span
                                    class="ms-1 d-none d-sm-inline">Customers</span></a>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>
            <div class="col py-3">
@endif
