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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
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

<body class="bg-gray-50 h-screen overflow-hidden flex text-sm">

    <!-- Mobile Sidebar Backdrop -->
    <div id="mobileBackdrop"
        class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 transition-opacity opacity-0 pointer-events-none md:hidden backdrop-blur-sm"
        aria-hidden="true" onclick="toggleSidebar()">
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:flex md:flex-col h-full shadow-2xl md:shadow-none">

        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center justify-center py-6 border-b border-gray-100 bg-white">
            <a href="{{ url('/') }}" class="flex items-center justify-center w-full px-4 group">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"
                    class="w-full h-auto object-contain group-hover:scale-105 transition-transform duration-200">
            </a>
            <!-- Close button for mobile -->
            <button class="md:hidden ml-auto text-gray-500 hover:text-gray-800" onclick="toggleSidebar()">
                <i class="bi bi-x-lg text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Nav -->
        <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1 custom-scrollbar">
            <div class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Menu
            </div>

            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('dashboard*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i
                        class="bi bi-speedometer2 mr-3 text-lg {{ request()->routeIs('dashboard*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    Dashboard
                </a>
            @endif

            <a href="{{ route('orders.index') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('orders.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-cart mr-3 text-lg {{ request()->routeIs('orders.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Orders
            </a>

            <a href="{{ route('customers.index') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('customers.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-people mr-3 text-lg {{ request()->routeIs('customers.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Customers
            </a>

            <div class="mt-8 px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Management
            </div>

            <a href="{{ route('service-categories.index') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('service-categories.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-folder mr-3 text-lg {{ request()->routeIs('service-categories.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Categories
            </a>

            <a href="{{ route('services.index') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('services.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-list-check mr-3 text-lg {{ request()->routeIs('services.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Services
            </a>

            <div class="mt-8 px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Finance & Reports
            </div>

            <a href="{{ route('payments.index') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('payments.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-credit-card mr-3 text-lg {{ request()->routeIs('payments.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Payments
            </a>

            <a href="{{ route('invoices.index') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('invoices.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-receipt mr-3 text-lg {{ request()->routeIs('invoices.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Invoices
            </a>

            <a href="{{ route('reports.orders') }}"
                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium group transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i
                    class="bi bi-graph-up mr-3 text-lg {{ request()->routeIs('reports.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Reports
            </a>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-200 bg-gray-50/50">
            @php
                $roleColors = [
                    'admin' => 'bg-red-100 text-red-700',
                    'manager' => 'bg-blue-100 text-blue-700',
                    'cashier' => 'bg-green-100 text-green-700',
                    'staff' => 'bg-purple-100 text-purple-700',
                ];
                $roleColor = $roleColors[Auth::user()->getRoleNames()->first()] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <div class="flex items-center space-x-3 mb-3">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <span
                        class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $roleColor }}">
                        {{ Auth::user()->getRoleNames()->first() }}
                    </span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center px-4 py-2 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 transition-all duration-200">
                    <i class="bi bi-box-arrow-right mr-2"></i>Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">

        <!-- Mobile Header -->
        <header
            class="md:hidden bg-white/80 backdrop-blur-lg border-b border-gray-200 flex items-center justify-between py-3 px-4 sticky top-0 z-30">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-20 w-auto">
            </div>
            <button onclick="toggleSidebar()"
                class="p-2 -mr-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-8 custom-scrollbar">

            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="max-w-7xl mx-auto mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex items-center justify-between animate-slide-in">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle-fill text-green-500 text-xl mr-3"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 ml-4">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="max-w-7xl mx-auto mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm flex items-center justify-between animate-slide-in">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-circle-fill text-red-500 text-xl mr-3"></i>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 ml-4">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif

            <!-- Page Content -->
            <div
                class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8 relative overflow-hidden">
                <!-- Background decorative elements -->
                <div
                    class="absolute top-0 right-0 -mt-16 -mr-16 w-32 h-32 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none">
                </div>
                <div
                    class="absolute bottom-0 left-0 -mb-16 -ml-16 w-32 h-32 bg-purple-50 rounded-full blur-3xl opacity-50 pointer-events-none">
                </div>

                <div class="relative">
                    @yield('content')
                </div>
            </div>

            <!-- Footer Credit -->
            <div class="mt-8 text-center text-xs text-gray-400 pb-4">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobileBackdrop');
            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                // Close
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            } else {
                // Open
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
            }
        }
    </script>
</body>

</html>