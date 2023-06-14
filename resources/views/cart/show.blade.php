@extends('layouts.footer')
@extends('layouts.app')

@section('titulo', 'Carrinho')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Espaço Privado</li>
        <li class="breadcrumb-item active">Carrinho</li>
    </ol>
@endsection

@section('main')
    <div>
        <h3>T-shirts no carrinho</h3>
    </div>
    @foreach ($cart as $item)
        <tr>
            <td>{{ $item->color }}</td>
            <td>{{ $item->size }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->product_id }}</td>
        </tr>
    @endforeach
    <div class="my-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="ok" form="formStore">Confirmar Compra</button>
        <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">Limpar Carrinho</button>
    </div>
    {{-- <form id="formStore" method="POST" action="{{ route('cart.store') }}" class="d-none">
        @csrf
    </form>
    <form id="formClear" method="POST" action="{{ route('cart.destroy') }}" class="d-none"> --}}
    @csrf
    @method('DELETE')
    </form>
@endsection
