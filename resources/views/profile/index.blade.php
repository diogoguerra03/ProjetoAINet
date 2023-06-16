@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>User Profile</h1>
            <div class="col-md-12 mt-5">
                @if (session('alert-msg'))
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                        {{ session('alert-msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @include('profile.shared.fields', ['readonlyData' => true])
                @can('update', $user)
                    <div class="my-4 d-flex justify-content-end">
                        <a href="{{ route('profile.edit', ['user' => $user]) }}" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-primary ms-3"><a class="dropdown-item"
                                href="{{ route('password.change.show') }}">Change password</a></button>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
