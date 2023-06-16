@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                <h1>Edit Profile</h1>
                <form method="POST" action="{{ route('profile.update') }}">
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
