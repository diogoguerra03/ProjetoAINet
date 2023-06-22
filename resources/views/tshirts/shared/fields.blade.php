@php
    $isCustomer = $customer ?? false ? 'disabled' : '';
@endphp

<div class="col-md-6">
    <img src="{{ route('photo', $tshirtImage) }}" alt="{{ $tshirtImage->name }}"
        class="img-fluid mx-auto d-block image-container">
</div>
<div class="col-md-6">
    @if ($isCustomer)
        <form novalidate class="needs-validation" method="POST"
            action="{{ route('tshirt.update', ['user' => $user, 'slug' => $tshirtImage->slug]) }}"
            enctype="multipart/form-data">
        @else
            <form novalidate class="needs-validation" method="POST"
                action="{{ route('catalog.update', $tshirtImage->slug) }}" enctype="multipart/form-data">
    @endif
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">{{ __('Name') }}</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $tshirtImage->name }}"
            required>
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">{{ __('Description') }}</label>
        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $tshirtImage->description }}</textarea>
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    @if (!$isCustomer)
        <div class="form-group">
            <label for="category">{{ __('Category') }}</label>
            <select class="form-control" id="category" name="category_id" required>
                <option value="" selected disabled>{{ __('Select category') }}</option>
                <option value="">{{ __('Without category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $tshirtImage->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if (isset($user) && $isCustomer)
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary" name="ok">{{ __('Update') }}</button>
            <a href="{{ route('profile.mytshirts', $user) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    @else
        <div class="form-group">
            <label for="image">{{ __('Image') }}</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary" name="ok">{{ __('Update') }}</button>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    @endif

    </form>
</div>
