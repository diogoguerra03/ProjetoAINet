@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form novalidate class="needs-validation" method="POST" action="{{ route('catalog.tshirt.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('tshirts.shared.create_fields', ['admin' => true])

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" name="ok">{{ __('Update') }}</button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
