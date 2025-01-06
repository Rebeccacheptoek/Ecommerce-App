@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <h1 class="text-3xl font-semibold mb-8 text-center">Shopping Cart</h1>

    @if(count($cartItems) > 0)
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
            @foreach($cartItems as $item)
                <div class="flex items-center justify-between border-b py-4">
                    <div class="flex items-center">
                        @if($item['product']->image_url)
                            <img src="{{ $item['product']->image_url }}"
                                 alt="{{ $item['product']->name }}"
                                 class="w-20 h-20 object-cover rounded-md">
                        @endif
                        <div class="ml-6">
                            <h3 class="font-semibold text-xl text-gray-800">{{ $item['product']->name }}</h3>
                            <p class="text-lg text-gray-600">${{ number_format($item['product']->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('cart.update', $item['product']->id) }}"
                              method="POST"
                              class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <input type="number"
                                   name="quantity"
                                   value="{{ $item['quantity'] }}"
                                   min="1"
                                   max="{{ $item['product']->stock }}"
                                   class="w-16 rounded-lg border-gray-300 p-2 text-center">
                            <button type="submit"
                                    class="ml-2 px-4 py-2 bg-gray-200 text-sm font-medium text-gray-700 rounded hover:bg-gray-300 transition">
                                Add
                            </button>
                        </form>
                        <form action="{{ route('cart.remove', $item['product']->id) }}"
                              method="POST"
                              class="ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-500 hover:text-red-700 text-lg">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="mt-8 flex justify-between items-center border-t pt-6">
                <div class="text-2xl font-semibold text-gray-800">
                    Total: ${{ number_format($total, 2) }}
                </div>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-6 py-3 bg-green-500 text-white text-lg font-semibold rounded-lg hover:bg-green-600 transition">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-xl text-gray-600 mb-6">Your cart is empty</p>
            <a href="{{ route('products.index') }}"
               class="px-8 py-4 bg-gray-800  text-white text-lg font-semibold rounded-lg hover:bg-gray-600 transition">
                Continue Shopping
            </a>
        </div>
    @endif
@endsection
