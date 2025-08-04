@extends('layout')

@section('title', 'Texon - Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary text-center">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $customerCount }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success text-center">
                    <div class="card-header">Pedidos pagos</div>
                    <div class="card-body">
                        <h5 class="card-title">R${{ $totalPagosMes }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger text-center">
                    <div class="card-header">Pedidos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderCount }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pedidos por Status</div>
                    <div class="card-body p-3">
                        <table class="table table-hover mb-4">
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

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card text-white bg-dark">
                    <div class="card-header">
                        Pedidos com entrega pendente ({{ $pendingDeliveryCount }})
                    </div>
                    <div class="card-body p-3">
                        <table class="table table-dark table-hover mb-4">
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
                                        <td class="d-grid">
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                                class="btn btn-sm btn-primary">Ver</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="4">Nenhum pedido pendente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 d-flex align-items-stretch">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Vendas por vendedor</div>
                    <div class="card-body p-3 h-100">
                        <canvas id="employeeSalesBar" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Metros de DTF impressos no mês / <strong>Total no mês:</strong> {{ number_format($totalMetrosMes, 2, ',', '.') }}
                            metros</div>
                    <div class="card-body p-3 h-100">
                        <canvas id="graficoMetrosDTF" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Metros Impressos
        const ctxMetros = document.getElementById('graficoMetrosDTF').getContext('2d');
        const chart = new Chart(ctxMetros, {
            type: 'bar',
            data: {
                labels: {!! json_encode($metrosPorDia->pluck('dia')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))) !!},
                datasets: [{
                    label: 'Metros Impressos',
                    data: {!! json_encode($metrosPorDia->pluck('total')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + 'm';
                            }
                        }
                    }
                }
            }
        });

        const ctxEmployeeSales = document.getElementById('employeeSalesBar');

        new Chart(ctxEmployeeSales, {
            type: 'bar',
            data: {
                labels: {!! json_encode($employeeSales->map(fn($e) => optional($e->employee)->first_name ?? 'Desconhecido')) !!},
                datasets: [{
                    label: 'Total de Vendas (R$)',
                    data: {!! json_encode($employeeSales->map(fn($e) => (float) $e->total)) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toFixed(2).replace('.', ',');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total de Vendas por Vendedor'
                    }
                }
            }
        });
    </script>
@endpush
