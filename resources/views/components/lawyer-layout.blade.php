@props(['header'])

<div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <x-navigation />

    <!-- Sidebar -->
    <div class="md:flex">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 bg-white shadow-md">
            <!-- Logo -->
            <div class="flex items-center h-16 px-6 border-b border-gray-200">
                <a href="{{ route('lawyer.dashboard') }}" class="flex items-center">
                    <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-2 text-xl font-semibold text-gray-900">Lawyer Panel</span>
                </a>
            </div>

            <!-- Sidebar Links -->
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 pt-5 pb-4 px-4 space-y-1">
                    @include('layouts.lawyer-sidebar')
                </nav>

                <!-- Logout Button -->
                <div class="border-t border-gray-200 p-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full group flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-md">
                            <svg class="mr-3 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <!-- Header -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                <div class="py-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</div> 