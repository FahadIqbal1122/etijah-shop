<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect('/admin/orders')->with('status', 'Order deleted.');
    }

    public function invoice(Order $order)
    {
        return view('admin.orders.invoice', compact('order'));
    }
}
