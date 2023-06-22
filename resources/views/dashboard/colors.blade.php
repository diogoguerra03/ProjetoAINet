@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="form-group d-flex">
        @php
            $colorsCount = $colors->count();
            $halfColorsCount = ceil($colorsCount / 2);
        @endphp

        @foreach ($colors->take($halfColorsCount) as $colorCode => $colorName)
            <div class="form-check form-check-inline">
                <input class="form-check-input color-option" type="radio" name="color"
                       id="{{ $colorCode }}" value="{{ $colorCode }}"
                       style="background-color: #{{ $colorCode }};">
            </div>
        @endforeach
    </div>
@endsection

