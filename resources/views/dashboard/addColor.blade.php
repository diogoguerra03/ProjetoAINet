@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Add Color</h1>
            <div class="col-md-12 mt-5">
                <form method="POST" action="{{ route('dashboard.storeColor') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="form-group w-25">
                        <label for="code">{{ __('Code') }}</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                            id="inputCode">
                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group w-25">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="inputNome">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group w-25">
                        <label for="image">{{ __('Image') }}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" name="ok">{{ __('Save') }}</button>
                        <a href="{{ route('dashboard.showColors') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
