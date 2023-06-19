@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-3 mt-0">Customers</h1>
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
                    @if ($user->blocked == 0)
                        <td><input class="form-check-input ms-3" type="checkbox" value="" id="flexCheckDisabled"
                                disabled></td>
                    @else
                        <td><input class="form-check-input ms-3" type="checkbox" value=""
                                id="flexCheckCheckedDisabled" checked disabled></td>
                    @endif
                    <td>
                        <div class="d-inline-flex align-content-center">
                            <i class="bi bi-trash "></i>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
