@extends('layouts.app')

@section('content')
    <div class="container">
    <form method="GET" action="{{ route('catalog.index') }}">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="inputCategory" class="form-label">Categoria</label>
                        <select class="form-select" name="category" id="inputCategory">
                            <option {{ old('category', $filterByCategory) === '' ? 'selected' : '' }} value="">Todas as categorias</option>
                            @foreach ($categories as $category)
                                <option {{ old('category', $filterByCategory) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inputNome" class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" name="name" id="inputNome" value="{{ old('name', $filterByName) }}" placeholder="Digite o nome do produto">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inputDescricao" class="form-label">Descrição do Produto</label>
                        <input type="text" class="form-control" name="description" id="inputDescricao" value="{{ old('description', $filterByDescription) }}" placeholder="Digite a descrição do produto">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="inputOrderBy" class="form-label">Ordenar por</label>
                    <select class="form-select" name="orderBy" id="inputOrderBy">
                        <option {{ old('orderBy', $orderBy) === '' ? 'selected' : '' }} value="">Novidades</option>
                        <option {{ old('orderBy', $orderBy) === 'name_asc' ? 'selected' : '' }} value="name_asc">Nome (Ascendente)</option>
                        <option {{ old('orderBy', $orderBy) === 'name_desc' ? 'selected' : '' }} value="name_desc">Nome (Descendente)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <button type="submit" class="btn btn-primary me-3">Filtrar</button>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>


        <div class="row mt-5">
            @forelse($tshirtImages as $tshirtImage)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top tshirt-image img-fluid mx-auto d-block image-container" src="{{ $tshirtImage->image_url }}"
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

        <div class="justify-content-center mt-5 ">
            {{ $tshirtImages->links() }}
        </div>
    </div>
@endsection
