@extends('layout')

@section('title', 'Texon - Impressões DTF')

@section('content')
    <h1>Impressões DTF</h1>
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
    <table class="table table-bordered table-striped" id="tabela-impressoes">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Data da impressão</th>
                <th scope="col">Metros</th>
                <th scope="col">Status</th>
                <th scope="col">Editar</th>
                <th scope="col">Excluir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtfPrints as $d)
                <tr>
                    <th scope="row">{{ $d->id }}</th>
                    <td>{{ $d->print_date }}</td>
                    <td>{{ $d->meters }}</td>
                    <td class="text-uppercase">{{ $d->status }}</td>
                    <td><a href="{{ route('dtfprints.edit', $d->id) }}" class="btn btn-sm btn-warning">Editar</a></td>
                    <td>
                        <form method="POST" action="{{ route('dtfprints.destroy', $d->id) }}">
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
                $('#tabela-impressoes').DataTable({
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
