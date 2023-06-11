@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $tshirtImage->image_url }}" alt="{{ $tshirtImage->name }}" class="image-container">
            </div>
            <div class="col-md-6">
                
                <form novalidate class="needs-validation" method="POST" action="{{ route('catalog.update', ['catalog' => $tshirtImage]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $tshirtImage->name }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="7" required>{{ $tshirtImage->description }}</textarea>
                    </div>

                    
                    <div class="form-group">
                        <label for="image">{{ __('Image') }}</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" name="ok">{{ __('Update') }}</button>
                        <a href="{{ route('catalog.show', $tshirtImage->slug) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
