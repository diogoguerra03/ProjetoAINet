@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Edit User</h1>
            @if (session('alert-msg'))
                <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                    {{ session('alert-msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12 mt-5">
                <form method="POST" action="{{ route('dashboard.updateData', ['user' => $user]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('profile.shared.fields')
                    <div class="d-flex justify-content-end">
                        <div class="mr-1">
                            <button type="submit" class="btn btn-primary" name="ok">Save</button>

                        </div>
                </form>
                @if ($user->photo_url)
                    <form id="deleteForm_{{ $user->id }}" method="POST"
                        action="{{ route('dashboard.deletephoto', ['user' => $user]) }}" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete photo</button>

                    </form>
                @endif
                <div class="ml-1">
                    @if ($user->user_type == 'A')
                        <a href="{{ route('dashboard.admins') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    @elseif($user->user_type == 'E')
                        <a href="{{ route('dashboard.employees') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection
