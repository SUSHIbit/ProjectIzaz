<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @guest
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('services')" :active="request()->routeIs('services')">
                            {{ __('Services') }}
                        </x-nav-link>
                        <x-nav-link :href="route('portfolio')" :active="request()->routeIs('portfolio')">
                            {{ __('Portfolio') }}
                        </x-nav-link>
                        <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                            {{ __('About Us') }}
                        </x-nav-link>
                        <x-nav-link :href="route('feedback')" :active="request()->routeIs('feedback')">
                            {{ __('Feedback') }}
                        </x-nav-link>
                    @endguest

                    @auth
                        @if (Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services*')">
                                {{ __('Services') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.portfolio.index')" :active="request()->routeIs('admin.portfolio*')">
                                {{ __('Portfolio') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings*')">
                                {{ __('Bookings') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.documents.index')" :active="request()->routeIs('admin.documents*')">
                                {{ __('Documents') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments*')">
                                {{ __('Payments') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.updates.index')" :active="request()->routeIs('admin.updates*')">
                                {{ __('Updates') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.feedback.index')" :active="request()->routeIs('admin.feedback*')">
                                {{ __('Feedback') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.team.index')" :active="request()->routeIs('admin.team*')">
                                {{ __('Team') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.services.index')" :active="request()->routeIs('user.services*')">
                                {{ __('Services') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.bookings.index')" :active="request()->routeIs('user.bookings*')">
                                {{ __('Bookings') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.documents.index')" :active="request()->routeIs('user.documents*')">
                                {{ __('Documents') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.payments.index')" :active="request()->routeIs('user.payments*')">
                                {{ __('Payments') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.updates.index')" :active="request()->routeIs('user.updates*')">
                                {{ __('Updates') }}
                            </x-nav-link>
                            <x-nav-link :href="route('user.feedback.index')" :active="request()->routeIs('user.feedback*')">
                                {{ __('Feedback') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @guest
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('services')" :active="request()->routeIs('services')">
                    {{ __('Services') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('portfolio')" :active="request()->routeIs('portfolio')">
                    {{ __('Portfolio') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                    {{ __('About Us') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('feedback')" :active="request()->routeIs('feedback')">
                    {{ __('Feedback') }}
                </x-responsive-nav-link>
            @endguest

            @auth
                @if (Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services*')">
                        {{ __('Services') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.portfolio.index')" :active="request()->routeIs('admin.portfolio*')">
                        {{ __('Portfolio') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings*')">
                        {{ __('Bookings') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.documents.index')" :active="request()->routeIs('admin.documents*')">
                        {{ __('Documents') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments*')">
                        {{ __('Payments') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.updates.index')" :active="request()->routeIs('admin.updates*')">
                        {{ __('Updates') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.feedback.index')" :active="request()->routeIs('admin.feedback*')">
                        {{ __('Feedback') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.team.index')" :active="request()->routeIs('admin.team*')">
                        {{ __('Team') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.services.index')" :active="request()->routeIs('user.services*')">
                        {{ __('Services') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.bookings.index')" :active="request()->routeIs('user.bookings*')">
                        {{ __('Bookings') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.documents.index')" :active="request()->routeIs('user.documents*')">
                        {{ __('Documents') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.payments.index')" :active="request()->routeIs('user.payments*')">
                        {{ __('Payments') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.updates.index')" :active="request()->routeIs('user.updates*')">
                        {{ __('Updates') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.feedback.index')" :active="request()->routeIs('user.feedback*')">
                        {{ __('Feedback') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                    
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endauth
    </div>
</nav>