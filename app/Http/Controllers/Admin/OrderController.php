<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\TapPaymentService;
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

    public function show(Order $order, TapPaymentService $tap)
    {
        $charge = null;
        $chargeError = null;

        if ($order->tap_charge_id) {
            try {
                $charge = $tap->retrieveCharge($order->tap_charge_id);
            } catch (\Throwable $e) {
                $chargeError = $e->getMessage();
            }
        }

        return view('admin.orders.show', compact('order', 'charge', 'chargeError'));
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
