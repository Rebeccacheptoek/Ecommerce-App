<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart(auth()->id());
        $total = collect($cartItems)->sum(function ($item) {
            return $item['product']->price * $item['quantity'];
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $this->cartService->addToCart(auth()->id(), $product->id, 1);
        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $this->cartService->addToCart(
            auth()->id(),
            $productId,
            $request->quantity,
            true
        );

        return redirect()->back()->with('success', 'Cart updated');
    }

    public function remove($productId)
    {
        $this->cartService->removeFromCart(auth()->id(), $productId);
        return redirect()->back()->with('success', 'Product removed from cart');
    }
}
