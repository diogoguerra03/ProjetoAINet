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
    <h1 class="text-center mb-3 mt-0">Categories</h1>
    <a href="{{ route('dashboard.addCategory') }}" class="text-decoration-none text-dark">
    <button type="button" class="btn btn-outline-dark mb-2">
        <div class="d-inline-flex align-items-center">
            <i class="bi bi-plus-circle mr-2 d-inline-flex align-items-center"></i>
            Add Category
        </div>
    </button>
    </a>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div class="d-inline-flex align-content-center">
                            <a href="{{ route('dashboard.editCategory', $category) }}" class="text-decoration-none ">
                            <button type="submit" class="btn btn-warning mb-2 ml-4 mr-3 text-white">
                                    <i class="bi bi-pencil"></i>
                            </button>
                            </a>
                            <form action="{{ route('dashboard.deleteCategory', $category->id) }}" method="POST"
                                id="deleteForm_{{ $category->id }}">
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
