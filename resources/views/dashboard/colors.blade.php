@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')
    @if (session('alert-msg'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            {{ session('alert-msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="text-center mb-3 mt-0">Color</h1>
    <button type="button" class="btn btn-outline-dark mb-2">
        <div class="d-inline-flex align-items-center">
            <i class="bi bi-plus-circle mr-2 d-inline-flex align-items-center"></i>
            Add Color
        </div>
    </button>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Code</th>
            <th scope="col">Name</th>
            <th scope="col">Color</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($colors as $color)
            <tr>
                <th scope="row">{{ $color->code }}</th>
                <td>{{ $color->name }}</td>
                <td>
                    <div class="d-inline-flex align-items-center">
                        <button type="button" class="btn rounded-circle p-3 btn-outline-dark" style="background-color: #{{ $color->code }}"></button>
                    </div>
                <td>
                    <div class="d-inline-flex align-content-center">
                        <button type="submit" class="btn btn-warning mb-2 ml-4 mr-3">
                            <a href="{{ route('dashboard.editColor', $color->code) }}" class="text-decoration-none text-white">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </button>
                        <form action="{{ route('dashboard.deleteColor', $color->code) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2">
                                <i class="bi bi-trash "></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
