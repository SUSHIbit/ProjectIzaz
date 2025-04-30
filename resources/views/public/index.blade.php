<!-- resources/views/public/index.blade.php -->
<x-app-layout>
    <div class="relative">
        <!-- Hero Section -->
        <div class="bg-blue-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                <div class="md:w-2/3">
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
                        Your Trusted Partner for Home Services
                    </h1>
                    <p class="mt-6 text-xl max-w-3xl">
                        From comprehensive renovations to minor repairs, we provide professional house services that bring your vision to life.
                    </p>
                    <div class="mt-10 flex items-center space-x-4">
                        <a href="{{ route('services') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-gray-50">
                            View Services
                        </a>
                        <a href="{{ route('portfolio') }}" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-blue-700">
                            Our Portfolio
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Services Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Our Featured Services
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        We offer a range of professional home services to keep your property at its best.
                    </p>
                </div>

                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($services as $service)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $service->title }}</h3>
                                <p class="text-gray-700 text-sm mb-4">{{ Str::limit($service->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-600 font-bold">${{ number_format($service->estimated_price, 2) }}</span>
                                    <a href="{{ route('services') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Learn more →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('services') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        View All Services
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Projects Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Recent Projects
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Explore some of our recent successful home renovation and improvement projects.
                    </p>
                </div>

                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    @foreach($portfolio as $project)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($project->images->count() > 0)
                                <img src="{{ asset('storage/' . $project->images->first()->image_path) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $project->title }}</h3>
                                <p class="text-gray-700 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Duration: {{ $project->duration_days }} days</span>
                                    <a href="{{ route('portfolio') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View project →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('portfolio') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        View All Projects
                    </a>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        What Our Clients Say
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Don't just take our word for it — see what our valued clients have to say.
                    </p>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($feedback as $testimonial)
                        <div class="bg-gray-50 rounded-lg p-6 shadow">
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
                            <p class="text-gray-600 mb-4">{{ Str::limit($testimonial->content, 150) }}</p>
                            <p class="text-sm font-medium text-gray-800">— {{ $testimonial->user->name }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('feedback') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Read All Testimonials
                    </a>
                </div>
            </div>
        </div>

        <!-- Team Members Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Meet Our Team
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Our dedicated professionals are here to bring your vision to life.
                    </p>
                </div>

                <div class="mt-12 grid gap-8 grid-cols-2 md:grid-cols-4">
                    @foreach($team as $member)
                        <div class="text-center">
                            <div class="mx-auto h-32 w-32 rounded-full overflow-hidden">
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $member->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $member->title }}</p>
                                <p class="text-xs text-gray-500">{{ $member->position }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 border-blue-600">
                        Learn More About Us
                    </a>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-blue-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                <div class="text-center md:w-2/3 mx-auto">
                    <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Ready to Transform Your Home?
                    </h2>
                    <p class="mt-4 text-xl">
                        Create an account today and get started with our professional home services.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-gray-50">
                            Register Now
                        </a>
                        <a href="{{ route('services') }}" class="ml-4 inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-blue-800">
                            Browse Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>