@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form novalidate class="needs-validation" method="POST" action="{{ route('tshirt.store', $user) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <input type="hidden" name="category_id" value="">
                    <input type="hidden" name="customer_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="image">{{ __('Image') }}</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" name="ok">{{ __('Update') }}</button>
                        <a href="{{ route('profile.mytshirts', $user) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
