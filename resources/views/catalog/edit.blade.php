@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('tshirts.shared.fields', ['customer' => false])
        </div>
    </div>
@endsection
