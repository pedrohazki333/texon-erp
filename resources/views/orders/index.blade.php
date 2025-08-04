@extends('layout')

@section('title', 'Pedidos')

@section('content')
    <h1>Pedidos</h1>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Ações
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Ver lista</a></li>
            <li><a class="dropdown-item" href="{{ route('orders.create') }}">Cadastrar</a></li>
        </ul>
    </div>
    <br>

    @if (session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    <table class="table table-bordered table-striped" id="tabela-pedidos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Total</th>
                <th>Data</th>
                <th>Vendedor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->employee->first_name }} {{ $order->customer->last_name }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form method="POST" action="{{ route('orders.destroy', $order->id) }}"
                            onsubmit="return confirm('Deseja realmente excluir este pedido?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tabela-pedidos').DataTable({
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
