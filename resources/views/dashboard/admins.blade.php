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
    <h1 class="text-center mb-3 mt-0">Administrators</h1>


    <hr>
    @include('dashboard.shared.filter')
    <hr>

    <a href="{{ route('dashboard.addAdmin') }}" class="text-decoration-none">
    <button type="button" class="btn btn-outline-dark mb-2">
        <div class="d-inline-flex align-items-center">
            <i class="bi bi-plus-circle mr-2 d-inline-flex align-items-center"></i>
            Add Administrator
        </div>
    </button>
    </a>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Blocked</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $user)
                @if ($user->id == Auth::user()->id)
                    @continue
                @endif
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('dashboard.user.block', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="blocked" value="{{ $user->blocked ? '0' : '1' }}">
                            <input type="checkbox" class="form-check-input ms-3" onchange="this.form.submit()"
                                {{ $user->blocked ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>
                        <div class="d-inline-flex align-content-center">
                            <a href="{{ route('dashboard.edit', $user) }}" class="text-decoration-none">
                                <button type="submit" class="btn btn-warning mb-2 ml-4 mr-3 text-white">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </a>
                            <form action="{{ route('dashboard.user.delete', $user->id) }}" method="POST"
                                id="deleteForm_{{ $user->id }}">
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
    <div class="justify-content-center mt-5 ">
        {{ $admins->withQueryString()->links() }}
    </div>
@endsection
