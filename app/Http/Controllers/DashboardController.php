<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $customerCount = Customer::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $ordersByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard', [
            'customerCount' => $customerCount,
            'productCount'  => $productCount,
            'orderCount'    => $orderCount,
            'ordersByStatus'=> $ordersByStatus,
        ]);
    }
}
