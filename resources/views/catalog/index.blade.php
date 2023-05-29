@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>T-Shirt Shop</h1>

        <form method="GET" action="{{ route('catalog.index') }}">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1 pe-2">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1 mb-3 form-floating">
                            <select class="form-select" name="category" id="inputCategory">
                                <option {{ old('category', $filterByCategory) === '' ? 'selected' : '' }} value="">
                                    Todas as categorias </option>
                                @foreach ($categories as $category)
                                    <option {{ old('category', $filterByCategory) == $category->id ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <label for="inputCategory" class="form-label">Categoria</label>
                        </div>

                    </div>
                    <div class="flex-grow-1 mb-3 form-floating">
                        <input type="text" class="form-control" name="nome" id="inputNome"
                            value="{{ old('nome', $filterByNome) }}" placeholder="Digite o nome do produto">
                        <label for="inputNome" class="form-label">Nome do Produto</label>
                    </div>
                </div>

                <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                    <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
                </div>
            </div>
        </form>

        <div class="row">
            @forelse($tshirtImages as $tshirtImage)
                <div class="col-md-4">
                    <div class="card h-100">
                        <img class="card-img-top tshirt-image img-fluid mx-auto d-block" src="{{ $tshirtImage->image_url }}"
                            alt="T-Shirt Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $tshirtImage->name }}</h5>
                            <p class="card-text">{{ $tshirtImage->description }}</p>
                            <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>Nenhuma imagem de tshirt encontrada.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination justify-content-center mt-5">
            {{ $tshirtImages->links() }}
        </div>
    </div>
@endsection
