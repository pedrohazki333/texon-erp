<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        // Total de pedidos pagos no mês atual
        $totalPagosOuEntreguesMes = Order::whereIn('status', ['pago', 'entregue'])
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

        return view('dashboard', [
            'customerCount' => $customerCount,
            'productCount'  => $productCount,
            'orderCount'    => $orderCount,
            'ordersByStatus' => $ordersByStatus,
            'totalPagosMes' => $totalPagosOuEntreguesMes,
            'pendingDeliveryOrders' => $pendingDeliveryOrders,
            'pendingDeliveryCount' => $pendingDeliveryCount,
        ]);
    }
}
