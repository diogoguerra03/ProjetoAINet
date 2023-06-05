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
        <h3>Disciplinas no carrinho</h3>
    </div>
    @if ($cart)
        {{-- @include('disciplinas.shared.table', [
            'disciplinas' => $cart,
            'showCurso' => true,
            'showDetail' => true,
            'showEdit' => false,
            'showDelete' => false,
            'showRemoveCart' => true,
        ]) --}}
        @foreach ($orderItem as $item)
            <tr>
                <td>{{ $item->tshirt_image_id }}</td>
                <td>{{ $disciplina->color_code }}</td>
                <td>{{ $disciplina->size }}</td>
                {{-- @if ($showCurso)
                    <td>{{ $disciplina->cursoRef->tipo }} - {{ $disciplina->cursoRef->nome }}</td>
                @endif
                <td>{{ $disciplina->ano }}</td>
                <td>{{ $disciplina->semestreStr }}</td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('disciplinas.show', ['disciplina' => $disciplina]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                @if ($showEdit)
                    <td class="button-icon-col"><a class="btn btn-dark"
                            href="{{ route('disciplinas.edit', ['disciplina' => $disciplina]) }}">
                            <i class="fas fa-edit"></i></a></td>
                @endif
                @if ($showDelete)
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('disciplinas.destroy', ['disciplina' => $disciplina]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="delete" class="btn btn-danger">
                                <i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                @endif
                @if ($showAddCart ?? false)
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('cart.add', ['disciplina' => $disciplina]) }}">
                            @csrf
                            <button type="submit" name="addToCart" class="btn btn-success">
                                <i class="fas fa-plus"></i></button>
                        </form>
                    </td>
                @endif
                @if ($showRemoveCart ?? false)
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('cart.remove', ['disciplina' => $disciplina]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="removeFromCart" class="btn btn-danger">
                                <i class="fas fa-remove"></i></button>
                        </form>
                    </td>
                @endif --}}
            </tr>
        @endforeach
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok" form="formStore">Confirmar Compra</button>
            <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">Limpar Carrinho</button>
        </div>
        <form id="formStore" method="POST" action="{{ route('cart.store') }}" class="d-none">
            @csrf
        </form>
        <form id="formClear" method="POST" action="{{ route('cart.destroy') }}" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
