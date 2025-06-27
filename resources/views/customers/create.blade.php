@extends('layout')

@section('title', 'Clientes')

@section('content')
    <h1>Clientes</h1>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Ações
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('customers.index') }}">Ver lista</a></li>
            <li><a class="dropdown-item" href="{{ route('customers.create') }}">Cadastrar</a></li>
        </ul>
    </div>
    <br>
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="last_name" name="last_name">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="address" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
