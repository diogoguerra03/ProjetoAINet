@extends('layouts.footer')
@extends('layouts.sidebar')
@extends('layouts.header')
@extends('layouts.app')


@section('content')
    <hr>
    <form method="GET" action="{{ route('dashboard.filterOrders') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 mb-3 form-floating">
                        <select class="form-select" name="curso" id="inputCurso">
                                <option {{ old('curso', $filterByCurso) == $curso->abreviatura ? 'selected' : '' }}
                                    value="{{ $curso->abreviatura }}">
                                    {{ $curso->tipo }} - {{ $curso->nome }}</option>
                        </select>
                        <label for="inputCurso" class="form-label">Curso</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <select class="form-select" name="ano" id="inputAno">
                            @for ($i = 1; $i <= 3; $i++)
                                <option {{ old('ano', $filterByAno) == $i ? 'selected' : '' }} value="{{ $i }}">
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <label for="inputAno" class="form-label">Ano</label>
                    </div>
                    <div class="mb-3 flex-grow-1 form-floating">
                        <select class="form-select" name="semestre" id="inputSemestre">
                            <option {{ old('semestre', $filterBySemestre) == 0 ? 'selected' : '' }} value="0">Anual
                            </option>
                            <option {{ old('semestre', $filterBySemestre) == 1 ? 'selected' : '' }} value="1">1º
                            </option>
                            <option {{ old('semestre', $filterBySemestre) == 2 ? 'selected' : '' }} value="2">2º
                            </option>
                        </select>
                        <label for="inputSemestre" class="form-label">Semestre</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="{{ route('disciplinas.index') }}"
                    class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>

    <!-- fim do filtro -->

    @if (session('alert-msg'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            {{ session('alert-msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="text-center mb-3 mt-0">Orders</h1>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                @if (Auth::user()->user_type === 'A')
                    <th scope="col"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    @if ($order->status != 'canceled' && $order->status != 'closed')
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Check details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->total_price }}€</td>
                        <td>{{ strtoupper($order->status) }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    @if (Auth::user()->user_type === 'E')
                                        @if ($order->status == 'pending')
                                            <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="paid">
                                                <button type="submit" class="btn btn-success mb-2">
                                                    Order paid
                                                </button>
                                            </form>
                                        @elseif($order->status == 'paid')
                                            <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="closed">
                                                <button type="submit" class="btn btn-warning mb-2">
                                                    Order closed
                                                </button>
                                            </form>
                                        @endif
                                    @elseif(Auth::user()->user_type === 'A')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-success mb-2">
                                                Order paid
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-success mb-2">
                                                Order paid
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="closed">
                                            <button type="submit" class="btn btn-warning mb-2">
                                                Order closed
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="row">
                                <div class="col">
                                    @if (Auth::user()->user_type === 'A')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-danger mb-2">
                                                Cancel order
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </td>
                    @elseif(Auth::user()->user_type === 'A' && ($order->status == 'canceled' || $order->status == 'closed'))
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->date }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('dashboard.orders.details', $order) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Check details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->total_price }}€</td>
                        <td>{{ strtoupper($order->status) }}</td>
                        <td></td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    @if ($order->status == 'closed')
                                        <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="canceled">
                                            <button type="submit" class="btn btn-danger mb-2">
                                                Cancel order
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
