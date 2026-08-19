<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    public function dashboard()
    {
        $this->authorizeAdmin();

        $usersCount = User::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'usersCount',
            'productsCount',
            'ordersCount',
            'pendingOrdersCount'
        ));
    }

    public function products()
    {
        $this->authorizeAdmin();

        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function editProduct(Product $product)
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Product $product)
    {
        $this->authorizeAdmin();

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function users()
    {
        $this->authorizeAdmin();

        $users = User::withCount('orders')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $this->authorizeAdmin();

        $user->loadCount('orders');

        $orders = $user->orders()
            ->latest()
            ->paginate(10);

        return view('admin.users.show', compact('user', 'orders'));
    }

    public function orders()
    {
        $this->authorizeAdmin();

        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $this->authorizeAdmin();

        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}
