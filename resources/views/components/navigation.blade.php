<!-- Top Navigation -->
<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" @click="open = !open" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Right side navigation items -->
            <div class="flex items-center">
                <span class="text-gray-700 text-sm font-medium">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" x-show="open" @click.away="open = false">
        <div class="pt-2 pb-3 space-y-1">
            @include('layouts.lawyer-sidebar')
        </div>
    </div>
</nav> 