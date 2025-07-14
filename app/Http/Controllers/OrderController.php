<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        $statuses = ['recebido', 'pago', 'arte pronta', 'impressão pronta', 'estampado', 'entregue'];
        return view('orders.create', compact('products', 'customers', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:recebido,pago,arte pronta,impressão pronta,estampado,entregue',
            'products.*.product_id' => 'required|exists:products,id',
            'notes' => 'nullable|string',
            'products.*.quantity' => 'required|numeric|min:0.1',
            'products.*.unit_price' => 'required|numeric|min:0'
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'status' => $request->status,
            'total' => 0,
            'notes' => $request->notes
        ]);

        $total = 0;
        foreach ($request->products as $item) {
            $subtotal = $item['quantity'] * $item['unit_price'];
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $subtotal
            ]);
            $total += $subtotal;
        }

        $order->update(['total' => $total]);

        return redirect()->route('orders.index')->with('sucesso', 'Pedido cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        $statuses = ['recebido', 'pago', 'arte pronta', 'impressão pronta', 'estampado', 'entregue'];
        return view('orders.edit', compact('order', 'customers', 'products', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:recebido,pago,arte pronta,impressão pronta,estampado,entregue',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $order->update([
            'customer_id' => $request->customer_id,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        // Apaga os itens antigos
        $order->items()->delete();

        $total = 0;
        foreach ($request->products as $item) {
            $subtotal = $item['quantity'] * $item['unit_price'];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $subtotal
            ]);
            $total += $subtotal;
        }

        $order->update(['total' => $total]);

        return redirect()->route('orders.index')->with('sucesso', 'Pedido atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('sucesso', 'Pedido excluído com sucesso!');
    }
}
