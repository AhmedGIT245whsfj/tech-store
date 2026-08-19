<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($product, $data) {
            $product = Product::lockForUpdate()->findOrFail($product->id);

            if ($product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'The requested quantity is not available in stock.',
                ]);
            }

            $total = (float) $product->price * $data['quantity'];

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'price' => $product->price,
            ]);

            $product->decrement('stock', $data['quantity']);
        });

        return redirect()
            ->route('web.orders.index')
            ->with('success', 'Order placed successfully.');
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product']);

        return view('orders.show', compact('order'));
    }
}
