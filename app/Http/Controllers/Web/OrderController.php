<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get the cart
            $cart = $this->cartService->getCart(auth()->id());
            if (empty($cart)) {
                return redirect()->back()->with('error', 'Your cart is empty');
            }

            \Log::info('Cart contents:', $cart);

            // Calculate total amount
            $totalAmount = collect($cart)->sum(function ($item) {
                return $item['product']->price * $item['quantity'];
            });

            \Log::info('Total amount calculated: ' . $totalAmount);

            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalAmount,
                'status' => 'pending'
            ]);
            \Log::info('Order created with ID: ' . $order->id);

            // Create order items and update product stock
            foreach ($cart as $item) {
                \Log::info('Processing item: ' . $item['product']->name . ' with quantity: ' . $item['quantity']);

                // Create order item
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['product']->price
                ]);

                // Update product stock
                $product = Product::findOrFail($item['product']->id);
                \Log::info('Product stock: ' . $product->stock . ', Quantity: ' . $item['quantity']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }
                $product->decrement('stock', $item['quantity']);
                \Log::info('Product stock after decrement: ' . $product->stock);
            }

            // Clear the cart after successful order
            $this->cartService->clearCart(auth()->id());

            DB::commit();

            // Redirect to order details with success message
            return redirect()->route('orders.index')
                ->with('success', 'Order placed successfully! Order #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Failed to place order. Please try again.' . $e->getMessage());
        }
    }


    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }
}
