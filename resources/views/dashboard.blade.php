@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <h2>{{ $customerCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pedidos Pagos (Mês Atual)</h5>
                    <h2>R${{ $totalPagosMes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pedidos</h5>
                    <h2>{{ $orderCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Pedidos por Status</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ordersByStatus as $status => $count)
                                <tr>
                                    <td>{{ ucfirst($status) }}</td>
                                    <td>{{ $count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Nenhum pedido encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Pedidos com entrega pendente ({{ $pendingDeliveryCount }})
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Última atualização</th>
                                <th>Cliente</th>
                                <th>Contato</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingDeliveryOrders as $order)
                                <tr>
                                    <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                                    <td>{{ $order->customer->phone }}</td>
                                    <td>
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-primary">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum pedido pendente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
