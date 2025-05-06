<x-sidebar-layout>
    <x-slot name="header">
        @if(isset($header))
            {{ $header }}
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($title) ? $title : 'User Dashboard' }}
            </h2>
        @endif
    </x-slot>

    {{ $slot }}
</x-sidebar-layout>