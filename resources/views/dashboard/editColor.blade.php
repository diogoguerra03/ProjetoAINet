@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Edit Color</h1>
            <div class="col-md-12 mt-5">
                <form method="POST" action="{{ route('dashboard.updateColor', ['color' => $color]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Category Name</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                       id="inputCode" value="{{ old('code', $color->code) }}">
                                @error('code')
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       id="inputNome" value="{{ old('nome', $color->name) }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="mr-1">
                            <button type="submit" class="btn btn-primary" name="ok">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
