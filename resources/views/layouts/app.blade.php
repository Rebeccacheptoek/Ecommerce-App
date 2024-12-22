<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce Store')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-200">
<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white">
                        Store
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">Products</a>
                        <a href="{{ route('cart.index') }}" class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">
                            <i class="fas fa-shopping-cart"></i>
                            @if(session()->has('cart_count'))
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs px-2">
                                    {{ session('cart_count') }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('orders.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">My Orders</a>
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white justify-end ">
                                @csrf
                                <button type="submit" class="px-3 py-2 text-sm font-medium">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="{{ route('products.index') }}" class="block rounded-md text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-base font-medium">Products</a>
            <a href="{{ route('cart.index') }}" class="block rounded-md text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-base font-medium">
                <i class="fas fa-shopping-cart"></i>
                @if(session()->has('cart_count'))
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs px-2">
                        {{ session('cart_count') }}
                    </span>
                @endif
            </a>
            <a href="{{ route('orders.index') }}" class="block rounded-md text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-base font-medium">My Orders</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-white shadow-lg mt-8">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <p class="text-center text-gray-600">&copy; {{ date('Y') }} E-Commerce Store. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
