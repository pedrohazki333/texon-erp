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
    <table class="table table-bordered table-striped" id="tabela-clientes">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Sobrenome</th>
                <th scope="col">Endereço</th>
                <th scope="col">Telefone</th>
                <th scope="col">Editar</th>
                <th scope="col">Excluir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $c)
                <tr>
                    <th scope="row">{{ $c->id }}</th>
                    <td>{{ $c->first_name }}</td>
                    <td>{{ $c->last_name }}</td>
                    <td>{{ $c->address }}</td>
                    <td>{{ $c->phone }}</td>
                    <td><a href="{{ route('customers.edit', $c->id) }}" class="btn btn-sm btn-warning">Editar</a></td>
                    <td>
                        <form method="POST" action="{{ route('customers.destroy', $c->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tabela-clientes').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
                    }
                });
            });
        </script>
    @endpush
@endsection
