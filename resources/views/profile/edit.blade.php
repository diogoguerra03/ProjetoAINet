@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Edit Profile</h1>
            <div class="col-md-12 mt-5">
                @if ($user->photo_url)
                    <form id="deleteUserForm_{{ $user->id }}" method="POST"
                        action="{{ route('profile.deletephoto', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger flex-fill">Delete photo</button>
                    </form>
                @endif

                <form method="POST" action="{{ route('profile.update', ['user' => $user]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('profile.shared.fields')
                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="ok">Guardar Alterações</button>
                        <a href="{{ route('profile', ['user' => $user]) }}" class="btn btn-secondary ms-3">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
