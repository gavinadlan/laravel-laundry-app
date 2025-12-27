<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'LaundryApp') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="bi bi-droplet-fill text-white text-xl"></i>
                    </div>
                    <a href="{{ url('/') }}" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        LaundryApp
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('customers.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customers.*') ? 'bg-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-people mr-2"></i>Customers
                    </a>
                    <a href="{{ route('services.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('services.*') ? 'bg-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-list-check mr-2"></i>Services
                    </a>
                    <a href="{{ route('orders.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('orders.*') ? 'bg-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-cart mr-2"></i>Orders
                    </a>
                    <a href="{{ route('payments.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('payments.*') ? 'bg-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-credit-card mr-2"></i>Payments
                    </a>
                    <a href="{{ route('reports.orders') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-indigo-100 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-graph-up mr-2"></i>Reports
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-4 ml-4 pl-4 border-l border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center">
                        <i class="bi bi-person-circle mr-2 text-indigo-600"></i>
                        {{ Auth::user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                            <i class="bi bi-box-arrow-right mr-2"></i>Logout
                        </button>
                    </form>
                </div>
                
                <!-- Mobile menu button -->
                <button class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100" onclick="toggleMobileMenu()">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-1">
                <a href="{{ route('customers.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('customers.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-people mr-2"></i>Customers
                </a>
                <a href="{{ route('services.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('services.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-list-check mr-2"></i>Services
                </a>
                <a href="{{ route('orders.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('orders.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-cart mr-2"></i>Orders
                </a>
                <a href="{{ route('payments.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('payments.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-credit-card mr-2"></i>Payments
                </a>
                <a href="{{ route('reports.orders') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-graph-up mr-2"></i>Reports
                </a>
                <div class="border-t border-gray-200 mt-2 pt-2">
                    <div class="px-4 py-2 text-sm text-gray-600">
                        <i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="px-4">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                            <i class="bi bi-box-arrow-right mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex items-center justify-between animate-slide-in">
                <div class="flex items-center">
                    <i class="bi bi-check-circle-fill text-green-500 text-xl mr-3"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 ml-4">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif
        
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>