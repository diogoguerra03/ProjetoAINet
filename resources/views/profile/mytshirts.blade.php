@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>My Tshirts</h1>
            @if (session('alert-msg'))
                <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                    {{ session('alert-msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @include('tshirts.shared.table', ['allowEdit' => true])
        </div>
    </div>
@endsection
