@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')

@section('content')

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Blocked</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $user)
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->blocked}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

@endsection
