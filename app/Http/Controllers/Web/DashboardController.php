<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $ordersCount = Order::where('user_id', auth()->id())->count();
        $latestProducts = Product::with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'productsCount',
            'ordersCount',
            'latestProducts'
        ));
    }
}
