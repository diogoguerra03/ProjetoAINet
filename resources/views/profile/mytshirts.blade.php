@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>My Tshirts</h1>
            <div class="row mt-5">
                @forelse($tshirts as $index => $tshirtImage)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="{{ route('catalog.show', $tshirtImage->slug) }}">

                                <img class="card-img-top img-fluid mx-auto d-block image-container"
                                    src="{{ route('photo', $tshirtImage) }}" alt="T-Shirt Image">

                            </a>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><b>{{ $tshirtImage->name }}</b></h5>

                                <p class="card-text">{{ $tshirtImage->description }}</p>
                                <a href="{{ route('catalog.show', $tshirtImage->slug) }}"
                                    class="btn btn-primary mt-auto">View
                                    product</a>
                                <div class="mt-3 d-flex">
                                    <a href="{{ route('tshirt.edit', ['user' => $user, 'slug' => $tshirtImage->slug]) }}"
                                        class="btn btn-success flex-fill mr-1">Edit</a>
                                    <div class="flex-fill ml-1">
                                        <form method="POST" action="{{ route('catalog.destroy', $tshirtImage->slug) }}"
                                            id="deleteForm_{{ $tshirtImage->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger flex-fill w-100">Delete</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>No tshirt image found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
