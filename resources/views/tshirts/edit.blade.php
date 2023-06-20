@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <img class="card-img-top img-fluid mx-auto d-block image-container" src="{{ route('photo', $tshirtImage) }}"
        alt="T-Shirt Image">
@endsection
