@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Products</h2>


            <div class="mb-6">
                <form action="{{ route('products.index') }}" method="GET" class="flex gap-4">
                    <div class="relative flex-1">
                        <input type="text"
                               name="search"
                               placeholder="Search products..."
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 rounded border-2 border-solid border-gray-600 shadow-sm">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-600"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                        </svg>
                    </div>
                    <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-600 border-2 border-solid border-gray-600">
                        Search
                    </button>
                </form>
            </div>


            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach($products as $product)
                    <div class="group">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}"
                                 alt="{{ $product->name }}"
                                 class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]">
                        @endif
                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                    class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-gray-800 px-8 py-3 text-base font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
