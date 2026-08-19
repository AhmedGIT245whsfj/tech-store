<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $orders = Order::with(['user', 'items.product'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request): OrderResource
    {
        $order = DB::transaction(function () use ($request) {
            $totalPrice = 0;
            $orderItems = [];

            foreach ($request->validated('items') as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => [
                            "Not enough stock for {$product->name}",
                        ],
                    ]);
                }

                $subtotal = (float) $product->price * $item['quantity'];

                $totalPrice += $subtotal;

                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        return new OrderResource(
            $order->load(['user', 'items.product'])
        );
    }

    public function show(Request $request, Order $order): OrderResource|JsonResponse
    {
        if (
            $request->user()->role !== 'admin' &&
            $order->user_id !== $request->user()->id
        ) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }

        return new OrderResource(
            $order->load(['user', 'items.product'])
        );
    }

    public function adminIndex(): AnonymousResourceCollection
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return OrderResource::collection($orders);
    }

    public function updateStatus(
        UpdateOrderStatusRequest $request,
        Order $order
    ): OrderResource {
        $order->update([
            'status' => $request->validated('status'),
        ]);

        return new OrderResource(
            $order->load(['user', 'items.product'])
        );
    }
}
