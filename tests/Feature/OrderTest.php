<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushall();
    }

    public function test_user_can_place_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100]);

        $cartService = app(CartService::class);
        $cartService->addToCart($user->id, $product->id, 2);

        $response = $this->actingAs($user)
            ->postJson('/api/orders');
        
        // dd($response->getContent());
        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'total_price',
                    'status',
                    'items' => [
                        '*' => [
                            'product_id',
                            'quantity',
                            'price'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 200,
            'status' => 'pending'
        ]);
    }

    public function test_user_can_view_their_orders()
    {
        $user = User::factory()->create();

        // Create an order for the user
        $product = Product::factory()->create();
        $cartService = app(CartService::class);
        $cartService->addToCart($user->id, $product->id, 1);

        $this->actingAs($user)
            ->postJson('/api/orders');

        $response = $this->actingAs($user)
            ->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'total_price',
                        'status',
                        'items'
                    ]
                ]
            ]);
    }
}
