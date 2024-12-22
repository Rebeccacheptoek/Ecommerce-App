<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request->user()->id);
        return response()->json(['data' => $cart]);
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $this->cartService->addToCart(
            $request->user()->id,
            $validated['product_id'],
            $validated['quantity']
        );

        return response()->json(['message' => 'Item added to cart']);
    }

    public function removeItem(Request $request, $productId)
    {
        $this->cartService->removeFromCart($request->user()->id, $productId);
        return response()->json(['message' => 'Item removed from cart']);
    }
}
