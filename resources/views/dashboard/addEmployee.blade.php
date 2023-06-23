@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Add User</h1>
            @if (session('alert-msg'))
                <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                    {{ session('alert-msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12 mt-5">
                <form method="POST" action="{{ route('dashboard.storeEmployee') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('dashboard.shared.fields')
                    <div class="d-flex justify-content-end">
                        <div class="mr-1">
                            <button type="submit" class="btn btn-primary" name="ok">Save</button>
                                <a href="{{ route('dashboard.employees') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
