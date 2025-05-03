<x-app-layout>
    <!-- Red header with centered text -->
    <section class="bg-red-600 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl font-bold">Login to Your Account</h1>
            <p class="mt-2">Welcome back! Sign in to access your services.</p>
        </div>
    </section>

    <!-- Main content with proper vertical centering -->
    <div class="flex flex-col justify-center" style="min-height: calc(100vh - 295px);">
        <div class="max-w-md mx-auto px-4 py-8 w-full">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-red-500">Forgot your password?</a>
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out w-full sm:w-auto">
                        LOG IN
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-red-600 hover:text-red-500">Register here</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer is properly positioned by flex layout -->
</x-app-layout>