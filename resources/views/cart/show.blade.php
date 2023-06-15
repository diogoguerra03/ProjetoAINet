@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')



@section('content')
    <div>
        <h3>T-shirts no carrinho</h3>
    </div>
    @foreach ($cart as $item)
        <tr>
            1
                <div>
                    <img src="{{ $item['product_id' ]}}" alt="T-Shirt Image">
                </div> /

            2 <td>{{ $item['color'] }}</td> /
            3 <td>{{ $item['size'] }}</td> /
            4 <td>{{ $item['quantity'] }}</td> /
            <br>
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
