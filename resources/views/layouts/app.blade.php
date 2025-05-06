<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Home Services') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        @auth
            <!-- For authenticated users, redirect to the appropriate dashboard using sidebar layout -->
            <script>
                window.location.href = "{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}";
            </script>
        @else
            <!-- Sticky Header for guests only -->
            <header class="sticky top-0 z-50 bg-white shadow-sm transition-all duration-200" id="header">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center">
                                <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="ml-2 text-xl font-semibold text-gray-900">Home Services</span>
                            </a>
                        </div>

                        <!-- Navigation Links - Center (for guests only) -->
                        <div class="hidden md:flex items-center justify-center flex-1 space-x-8">
                            <a href="{{ route('services') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('services') ? 'text-red-600 font-semibold' : '' }}">
                                Services
                            </a>
                            <a href="{{ route('portfolio') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('portfolio') ? 'text-red-600 font-semibold' : '' }}">
                                Portfolio
                            </a>
                            <a href="{{ route('about') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-red-600 font-semibold' : '' }}">
                                About Us
                            </a>
                            <a href="{{ route('feedback') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('feedback') ? 'text-red-600 font-semibold' : '' }}">
                                Feedback
                            </a>
                        </div>

                        <!-- Auth Buttons - Right (for guests only) -->
                        <div class="hidden md:flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg border border-transparent hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                Register
                            </a>
                        </div>

                        <!-- Mobile menu button (for guests) -->
                        <div class="md:hidden flex items-center">
                            <button type="button" class="mobile-menu-button text-gray-700 hover:text-red-600 focus:outline-none" aria-label="Toggle menu">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu for guests -->
                <div class="md:hidden mobile-menu hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t">
                        <a href="{{ route('services') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('services') ? 'text-red-600 font-semibold' : '' }}">Services</a>
                        <a href="{{ route('portfolio') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('portfolio') ? 'text-red-600 font-semibold' : '' }}">Portfolio</a>
                        <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('about') ? 'text-red-600 font-semibold' : '' }}">About Us</a>
                        <a href="{{ route('feedback') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('feedback') ? 'text-red-600 font-semibold' : '' }}">Feedback</a>
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600">Login</a>
                        <a href="{{ route('register') }}" class="mt-1 block px-3 py-2 text-base font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Register</a>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-screen-xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-screen-xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        @endauth

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="md:flex md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="ml-2 text-xl font-semibold text-gray-900">Home Services</span>
                        </a>
                        <p class="mt-2 text-sm text-gray-600 max-w-md">
                            Professional home services to transform your living spaces with quality workmanship and excellent customer service.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-8 sm:grid-cols-3">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Services</h3>
                            <ul class="mt-4 space-y-2">
                                <li>
                                    <a href="{{ route('services') }}" class="text-gray-600 hover:text-red-600 text-sm">All Services</a>
                                </li>
                                <li>
                                    <a href="{{ route('portfolio') }}" class="text-gray-600 hover:text-red-600 text-sm">Our Work</a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Company</h3>
                            <ul class="mt-4 space-y-2">
                                <li>
                                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 text-sm">About Us</a>
                                </li>
                                <li>
                                    <a href="{{ route('feedback') }}" class="text-gray-600 hover:text-red-600 text-sm">Testimonials</a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Legal</h3>
                            <ul class="mt-4 space-y-2">
                                <li>
                                    <a href="#" class="text-gray-600 hover:text-red-600 text-sm">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 hover:text-red-600 text-sm">Terms of Service</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                    <div class="flex space-x-6 md:order-2">
                        <!-- Social Links -->
                        <a href="#" class="text-gray-400 hover:text-red-600">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-600">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <p class="mt-8 text-sm text-gray-500 md:mt-0 md:order-1">
                        &copy; {{ date('Y') }} Home Services. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Header scroll effect
            const header = document.getElementById('header');
            if (header) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 10) {
                        header.classList.add('shadow');
                    } else {
                        header.classList.remove('shadow');
                    }
                });
            }
        });
    </script>
</body>
</html>