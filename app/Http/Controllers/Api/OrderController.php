<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $orders = Order::with('items.product')
            // ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $orders]);
    }

    public function store(Request $request)
    {
        $cart = $this->cartService->getCart($request->user()->id);

        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($cart as $item) {
                $price = (float) $item['product']->price;
                $totalAmount += $price * $item['quantity'];
            }
            // dd($totalAmount);
            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_price' => $totalAmount,
                'status' => 'pending'
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['product']->price
                ]);
            }

            $this->cartService->clearCart($request->user()->id);

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully',
                'data' => $order->load('items.product')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage()); 
            return response()->json(['message' => 'Failed to place order'], 500);
        }
    }
}
