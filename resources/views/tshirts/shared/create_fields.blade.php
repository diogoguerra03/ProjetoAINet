@php
    $isAdmin = $admin ?? false ? 'disabled' : '';
@endphp

<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
        rows="3" required></textarea>
    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

@if ($isAdmin)
    <div class="form-group">
        <label for="category">{{ __('Category') }}</label>
        <select class="form-control" id="category" name="category_id" required>
            <option value="">{{ __('Without category') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
@endif

<div class="form-group">
    <label for="image">{{ __('Image') }}</label>
    <input type="file" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url"
        accept="image/*" required>
    @error('image_url')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
