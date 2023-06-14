@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                <h1>Edit User Profile</h1>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                @if (asset(Auth::user()->photo_url))
                                    <img src="{{ asset('storage/photos/' . Auth::user()->photo_url) }}" alt="avatar"
                                        class="rounded-circle img-fluid" style="width: 150px;">
                                @else
                                    <i class="fa fa-user icon icon-lg rounded-circle border"></i>
                                @endif

                                <div class="card-body text-center">
                                    <button type="button" class="btn btn-primary">Change Photo</button>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-2">
                            <div class="card-body">
                                <form novalidate class="needs-validation" method="POST"
                                    action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" class="form-control"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control"
                                                value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
