<x-app-layout>
    <div class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                Client Testimonials
            </h1>
            <p class="mt-4 text-xl max-w-3xl">
                See what our satisfied clients have to say about our home services.
            </p>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($feedback->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($feedback as $testimonial)
                        <div class="bg-white rounded-lg p-6 shadow">
                            <div class="flex items-center mb-4">
                                @if($testimonial->rating)
                                    <div class="flex text-yellow-400">
                                        @for($i = 0; $i < $testimonial->rating; $i++)
                                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        @for($i = $testimonial->rating; $i < 5; $i++)
                                            <svg class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $testimonial->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ $testimonial->content }}</p>
                            <p class="text-sm font-medium text-gray-800">— {{ $testimonial->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $testimonial->created_at->format('M d, Y') }}</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $feedback->links() }}
                </div>
                
                <div class="mt-12 bg-gray-50 rounded-lg p-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Share Your Experience</h3>
                    <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                        We value your feedback! Create an account or log in to share your experience with our home services.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-blue-600 text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50">
                            Create Account
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Testimonials Yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Be the first to share your experience with our services.</p>
                    <div class="mt-6">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create an Account
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>