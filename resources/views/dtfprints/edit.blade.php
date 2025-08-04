@extends('layout')

@section('title', 'Texon - Editar impressão DTF')

@section('content')
    <h1>Editar impressão DTF</h1>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Ações
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('dtfprints.index') }}">Ver lista</a></li>
            <li><a class="dropdown-item" href="{{ route('dtfprints.create') }}">Cadastrar</a></li>
        </ul>
    </div>
    <br>
    <form method="POST" action="{{ route('dtfprints.update', $dtfPrint->id) }}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="print_date" class="form-label">Data da impressão</label>
                <input type="date" class="form-control" id="print_date" name="print_date" value="{{ $dtfPrint->print_date }}">
            </div>
            <div class="col-md-6">
                <label for="meters" class="form-label">Metros</label>
                <input type="number" step="0.01" class="form-control" id="meters" name="meters" value="{{ $dtfPrint->meters }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    @foreach ($statuses as $s)
                        <option class="text-uppercase" value="{{ $s }}" {{ $dtfPrint->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
