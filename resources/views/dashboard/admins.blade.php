@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')

    <h1 class="text-center mb-3 mt-0">Administrators</h1>
    <button type="button" class="btn btn-outline-dark mb-2">
        <div class="d-inline-flex align-items-center">
            <i class="bi bi-plus-circle mr-2 d-inline-flex align-items-center"></i>
            Add Administrator
        </div>
    </button>
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
        @foreach($admins as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                @if($user->blocked == 0)
                    <td><input class="form-check-input ms-3" type="checkbox" value="" id="flexCheckDisabled" disabled></td>
                @else
                    <td><input class="form-check-input ms-3" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled></td>
                @endif
                <td>
                    <div class="d-inline-flex align-content-center">
                        <i class="bi bi-pencil ml-4 mr-3"></i>
                        <i class="bi bi-trash "></i>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
