@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                <h1>User Profile</h1>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">

                                @if (Auth::user()->photo_url)
                                    <img src="{{ asset('storage/photos/' . Auth::user()->photo_url) }}" alt="avatar"
                                        class="rounded-circle img-fluid" style="width: 150px;">
                                @else
                                    <i class="fa fa-user icon icon-lg rounded-circle border"></i>
                                @endif

                                <h5 class="my-3">{{ Auth::user()->name }}</h5>

                                @if (Auth::user()->user_type === 'C')
                                    <p class="text-muted mt-4 mb-1">Client</p>
                                @endif
                                @if (Auth::user()->user_type === 'A')
                                    <p class="text-muted mt-4 mb-1">Administrator</p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ Auth::user()->name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Creation Date</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ Auth::user()->created_at }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Last Update</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ Auth::user()->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('update', Auth::user())
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg">Edit</a>
                            <button type="button" class="btn btn-secondary btn-lg"><a class="dropdown-item"
                                    href="{{ route('password.change.show') }}">Change password</a></button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
