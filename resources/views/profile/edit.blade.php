@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Edit Profile</h1>
            <div class="col-md-12 mt-5">
                <form method="POST" action="{{ route('profile.update', ['user' => $user]) }}" enctype="multipart/form-data">
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
                        action="{{ route('profile.deletephoto', ['user' => $user]) }}" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete photo</button>
                        <a href="{{ route('profile', ['user' => $user]) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
