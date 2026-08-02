<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'paid_orders' => Order::where('status', 'paid')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'revenue' => Order::where('status', 'paid')->sum('amount'),
            'products' => Product::count(),
            'active_products' => Product::where('active', true)->count(),
        ];

        $recentOrders = Order::latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
