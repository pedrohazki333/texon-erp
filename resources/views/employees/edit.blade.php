@extends('layout')

@section('title', 'Texon - Editar dados do funcionário')

@section('content')
    <h1>Editar dados do funcionário</h1>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Ações
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('employees.index') }}">Ver lista</a></li>
            <li><a class="dropdown-item" href="{{ route('employees.create') }}">Cadastrar</a></li>
        </ul>
    </div>
    <br>
    <form method="POST" action="{{ route('employees.update', $employee->id) }}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="{{ $employee->first_name }}">
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="{{ $employee->last_name }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
@endsection
