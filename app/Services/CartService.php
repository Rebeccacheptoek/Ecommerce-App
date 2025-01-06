<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class CartService
{
    private $redis;
    private $cartPrefix = 'cart:';

    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function getCartKey($userId)
    {
        return $this->cartPrefix . $userId;
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        $cartKey = $this->getCartKey($userId);

        // Store cart item in Redis
        $currentQuantity = $this->redis->hget($cartKey, $productId) ?? 0;
        $this->redis->hset($cartKey, $productId, $currentQuantity + 1);

        return true;
    }

    public function removeFromCart($userId, $productId)
    {
        $cartKey = $this->getCartKey($userId);
        $this->redis->hdel($cartKey, $productId);
        return true;
    }

    public function getCart($userId)
    {
        $cartKey = $this->getCartKey($userId);
        $cartItems = $this->redis->hgetall($cartKey);

        $cart = [];
        foreach ($cartItems as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cart[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $cart;
    }

    public function clearCart($userId)
    {
        $cartKey = $this->getCartKey($userId);
        $this->redis->del($cartKey);
    }
}
