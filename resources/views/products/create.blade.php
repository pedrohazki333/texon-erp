@extends('layout')

@section('title', 'Produtos')

@section('content')
    <h1>Produtos</h1>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Ações
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('products.index') }}">Ver lista</a></li>
            <li><a class="dropdown-item" href="{{ route('products.create') }}">Cadastrar</a></li>
        </ul>
    </div>
    <br>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="product_name" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Digite o nome do produto">
            </div>
            <div class="col-md-6">
                <label for="description" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Digite a descrição do produto">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="price" class="form-label">Preço</label>
                <input type="decimal" class="form-control" id="price" name="price" placeholder="Digite o preço do produto">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="quantity" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Digite a quantidade do produto">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
