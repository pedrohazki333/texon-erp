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
    <form method="POST" action="{{ route('products.update', $product->id) }}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="product_name" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="{{ $product->product_name }}">
            </div>
            <div class="col-md-6">
                <label for="description" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="description" name="description"
                    value="{{ $product->description }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="price" class="form-label">Preço</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="quantity" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
