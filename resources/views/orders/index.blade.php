@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    @if(count($orders) > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-semibold text-lg">Order #{{ $order->id }}</h3>
                            <p class="text-gray-600">
                                Placed on {{ $order->created_at->format('M d, Y') }}
                            </p>
                        </div>

                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-2 text-lg">Order Items</h4>
                        <div class="space-y-2">
                            <?php $totalPrice = 0 ?>
                            @foreach($order->items as $item)
                                <?php $totalPrice += $item->price * $item->quantity;?>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            Quantity: {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <p class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            @endforeach
                            <div class="text-right">
                                <p class="font-semibold text-lg">Total: ${{ number_format($totalPrice, 2) }}</p>
                                <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600 mb-4">You haven't placed any orders yet</p>
            <a href="{{ route('products.index') }}"
               class="px-6 py-3 bg-indigo-800 text-white rounded-lg hover:bg-gray-800 transition-colors">
                Start Shopping
            </a>
        </div>
    @endif
@endsection
