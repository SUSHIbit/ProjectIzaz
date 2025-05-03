<!-- resources/views/public/about.blade.php -->
<x-app-layout>
    <!-- Hero Section with Background Image -->
    <section class="relative bg-cover bg-center h-[400px]" style="background-image: url('https://images.unsplash.com/photo-1513467535987-fd81bc7d62f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-center mx-auto max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                    About Us
                </h1>
                <p class="mt-4 text-xl text-white">
                    Learn more about our company and the dedicated team behind our services.
                </p>
            </div>
        </div>
    </section>

    <!-- Our Story Section - Keep the layout as is -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div>
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                        Our Story
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">A decade of transforming homes</h2>
                    <div class="text-gray-600 space-y-4 text-lg leading-relaxed">
                        <p>
                            Founded with a passion for quality home services, we've been transforming homes and exceeding client expectations for over a decade.
                        </p>
                        <p>
                            Our journey began with a simple mission: to provide homeowners with reliable, professional, and high-quality home services. What started as a small team of dedicated professionals has grown into a trusted name in the industry.
                        </p>
                        <p>
                            We believe that every home deserves the best care and attention. Our approach combines skilled craftsmanship with personalized service, ensuring that each project we undertake reflects our commitment to excellence.
                        </p>
                        <p>
                            Today, we continue to build on our foundation of trust and quality, expanding our services to meet the evolving needs of homeowners while maintaining the personal touch that has become our hallmark.
                        </p>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1590725140246-20acddc1ec6b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Team working" class="rounded-2xl shadow-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet the Team Section - NEW -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                    Meet the Team
                </span>
                <h2 class="text-3xl font-bold text-gray-900">Our Talented Professionals</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Our dedicated team brings years of expertise to every project we undertake.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($team && $team->count() > 0)
                    @foreach($team as $member)
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="aspect-square overflow-hidden">
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900">{{ $member->name }}</h3>
                                <p class="text-red-600 font-medium">{{ $member->title }}</p>
                                <p class="mt-2 text-gray-600 text-sm">{{ $member->position }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback if no team members in DB -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                        <div class="aspect-square overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Team Member" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">John Doe</h3>
                            <p class="text-red-600 font-medium">CEO & Founder</p>
                            <p class="mt-2 text-gray-600 text-sm">Leading our vision with 15+ years experience</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                        <div class="aspect-square overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Team Member" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">Jane Smith</h3>
                            <p class="text-red-600 font-medium">Lead Designer</p>
                            <p class="mt-2 text-gray-600 text-sm">Creating beautiful spaces for our clients</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                        <div class="aspect-square overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1556157382-97eda2f9e2bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Team Member" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">Mike Johnson</h3>
                            <p class="text-red-600 font-medium">Project Manager</p>
                            <p class="mt-2 text-gray-600 text-sm">Ensuring projects are delivered on time</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Our Values Section - Keep as is -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                    Our Values
                </span>
                <h2 class="text-3xl font-bold text-gray-900">What drives us forward</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Our core values guide everything we do, from how we interact with clients to how we approach each project.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-red-100 text-red-600 mb-6">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Quality</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We never compromise on quality. From the materials we use to the craftsmen we employ, we ensure that every aspect of our work meets the highest standards of excellence.
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-red-100 text-red-600 mb-6">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Communication</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We believe in open and transparent communication with our clients. We keep you informed throughout the entire process, ensuring your vision is realized exactly as you imagined.
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-red-100 text-red-600 mb-6">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Timeliness</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We understand the importance of completing projects on schedule. Our efficient workflows and experienced team ensure that we deliver on time, every time.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>