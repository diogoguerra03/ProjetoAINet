@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Edit User</h1>
            <div class="col-md-12 mt-5">
                <form method="POST" action="{{ route('dashboard.updateData', ['user' => $user]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('dashboard.shared.fields')
                    <div class="d-flex justify-content-end">
                        <div class="mr-1">
                            <button type="submit" class="btn btn-primary" name="ok">Save</button>
                        </div>
                    </div>
                </form>
                @if ($user->photo_url)
                    <form id="deleteUserForm_{{ $user->id }}" method="POST"
                          action="{{ route('dashboard.deletephoto', ['user' => $user]) }}" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete photo</button>
                        @if($user->user_type == 'A')
                            <a href="{{ route('dashboard.admins') }}" class="btn btn-secondary">Cancel</a>
                        @elseif($user->user_type == 'E')
                            <a href="{{ route('dashboard.employees') }}" class="btn btn-secondary">Cancel</a>
                        @endif
                    </form>
                @endif
            </div>

        </div>
    </div>
@endsection
