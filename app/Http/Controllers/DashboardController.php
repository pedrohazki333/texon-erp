<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\DtfPrint;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        // Total de pedidos pagos no mês atual
        $totalPagosOuEntreguesMes = Order::whereIn('status', ['pago', 'entregue', 'arte pronta', 'impressão pronta', 'estampado'])
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total');

        $customerCount = Customer::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $ordersByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $pendingDeliveryOrders = Order::where('status', '!=', 'entregue')
            ->with('customer')
            ->orderByDesc('updated_at')
            ->get();

        $pendingDeliveryCount = $pendingDeliveryOrders->count();

        $employeeSales = Order::selectRaw('employee_id, SUM(total) as total')
            ->whereIn('status', ['pago', 'entregue', 'arte pronta', 'impressão pronta', 'estampado'])
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy('employee_id')
            ->with('employee') // eager load
            ->get();

        // Total de metros impressos no mês atual
        $totalMetrosMes = DtfPrint::whereMonth('print_date', $now->month)
            ->whereYear('print_date', $now->year)
            ->sum('meters');

        // Metros impressos por dia (para o gráfico)
        $metrosPorDia = DtfPrint::selectRaw('DATE(print_date) as dia, SUM(meters) as total')
            ->whereMonth('print_date', $now->month)
            ->whereYear('print_date', $now->year)
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return view('dashboard', [
            'customerCount' => $customerCount,
            'productCount'  => $productCount,
            'orderCount'    => $orderCount,
            'ordersByStatus' => $ordersByStatus,
            'totalPagosMes' => $totalPagosOuEntreguesMes,
            'pendingDeliveryOrders' => $pendingDeliveryOrders,
            'pendingDeliveryCount' => $pendingDeliveryCount,
            'employeeSales' => $employeeSales,
            'totalMetrosMes' => $totalMetrosMes,
            'metrosPorDia' => $metrosPorDia,
        ]);
    }
}
