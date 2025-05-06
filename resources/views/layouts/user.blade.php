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
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar Navigation for desktop -->
        <div class="hidden md:fixed md:flex md:flex-col md:w-64 md:inset-y-0 bg-white shadow-md z-10">
            <!-- Logo -->
            <div class="flex items-center h-16 px-6 border-b border-gray-200">
                <a href="{{ route('home') }}" class="flex items-center">
                    <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-2 text-xl font-semibold text-gray-900">Home Services</span>
                </a>
            </div>

            <!-- Sidebar Links -->
            <div class="flex-1 flex flex-col overflow-y-auto pt-5 pb-4">
                <nav class="mt-5 flex-1 px-4 space-y-1">
                    @if(Auth::user()->isAdmin())
                        <!-- Admin Links -->
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.services*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Manage Services
                        </a>
                        
                        <a href="{{ route('admin.portfolio.index') }}" class="{{ request()->routeIs('admin.portfolio*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.portfolio*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Portfolio Projects
                        </a>
                        
                        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.bookings*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Bookings
                        </a>
                        
                        <a href="{{ route('admin.documents.index') }}" class="{{ request()->routeIs('admin.documents*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.documents*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Documents
                        </a>
                        
                        <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.payments*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Payments
                        </a>
                        
                        <a href="{{ route('admin.updates.index') }}" class="{{ request()->routeIs('admin.updates*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.updates*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Project Updates
                        </a>
                        
                        <a href="{{ route('admin.feedback.index') }}" class="{{ request()->routeIs('admin.feedback*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.feedback*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Feedback
                        </a>
                        
                        <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.team*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Team Members
                        </a>
                        
                        <a href="{{ route('admin.chat.index') }}" class="{{ request()->routeIs('admin.chat*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md relative">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.chat*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Chat Support
                            @php
                                $unreadCount = \App\Models\Message::where('sender_role', 'user')
                                    ->where('is_read', false)
                                    ->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute right-2 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                    @else
                        <!-- User Links -->
                        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.dashboard') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('user.services.index') }}" class="{{ request()->routeIs('user.services*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.services*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Book a Service
                        </a>
                        
                        <a href="{{ route('user.bookings.index') }}" class="{{ request()->routeIs('user.bookings*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.bookings*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            My Bookings
                        </a>
                        
                        <a href="{{ route('user.documents.index') }}" class="{{ request()->routeIs('user.documents*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.documents*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            My Documents
                        </a>
                        
                        <a href="{{ route('user.payments.index') }}" class="{{ request()->routeIs('user.payments*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.payments*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Payments
                        </a>
                        
                        <a href="{{ route('user.updates.index') }}" class="{{ request()->routeIs('user.updates*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.updates*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Project Updates
                        </a>
                        
                        <a href="{{ route('user.feedback.index') }}" class="{{ request()->routeIs('user.feedback*') ? 'bg-red-50 text-red-600' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} group flex items-center px-4 py-2 text-sm font-medium rounded-md">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('user.feedback*') ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Feedback
                        </a>
                    @endif
                </nav>
            </div>
            
            <!-- Logout Button at bottom of sidebar -->
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

        <!-- Mobile menu -->
        <div class="md:hidden" x-data="{ open: false }">
            <!-- Mobile menu button and top navbar -->
            <div class="bg-white shadow">
                <div class="px-4 flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <button @click="open = !open" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500 p-2">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <a href="{{ route('home') }}" class="ml-2 flex items-center">
                            <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="ml-2 text-lg font-semibold text-gray-900">Home Services</span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Mobile menu content -->
            <div class="bg-white shadow-md" x-show="open" x-cloak @click.away="open = false">
                <div class="pt-2 pb-3 space-y-1">
                    @if(Auth::user()->isAdmin())
                        <!-- Admin Links - Mobile -->
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Manage Services
                        </a>
                        
                        <a href="{{ route('admin.portfolio.index') }}" class="{{ request()->routeIs('admin.portfolio*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Portfolio Projects
                        </a>
                        
                        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Bookings
                        </a>
                        
                        <a href="{{ route('admin.documents.index') }}" class="{{ request()->routeIs('admin.documents*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Documents
                        </a>
                        
                        <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Payments
                        </a>
                        
                        <a href="{{ route('admin.updates.index') }}" class="{{ request()->routeIs('admin.updates*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Project Updates
                        </a>
                        
                        <a href="{{ route('admin.feedback.index') }}" class="{{ request()->routeIs('admin.feedback*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Feedback
                        </a>
                        
                        <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Team Members
                        </a>
                        
                        <a href="{{ route('admin.chat.index') }}" class="{{ request()->routeIs('admin.chat*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium relative">
                            Chat Support
                            @php
                                $unreadCount = \App\Models\Message::where('sender_role', 'user')
                                    ->where('is_read', false)
                                    ->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                    @else
                        <!-- User Links - Mobile -->
                        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Dashboard
                        </a>
                        
                        <a href="{{ route('user.services.index') }}" class="{{ request()->routeIs('user.services*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Book a Service
                        </a>
                        
                        <a href="{{ route('user.bookings.index') }}" class="{{ request()->routeIs('user.bookings*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            My Bookings
                        </a>
                        
                        <a href="{{ route('user.documents.index') }}" class="{{ request()->routeIs('user.documents*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            My Documents
                        </a>
                        
                        <a href="{{ route('user.payments.index') }}" class="{{ request()->routeIs('user.payments*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Payments
                        </a>
                        
                        <a href="{{ route('user.updates.index') }}" class="{{ request()->routeIs('user.updates*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Project Updates
                        </a>
                        
                        <a href="{{ route('user.feedback.index') }}" class="{{ request()->routeIs('user.feedback*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
                            Feedback
                        </a>
                    @endif

                    <!-- Logout Link - Mobile -->
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-base font-medium text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:pl-64 flex flex-col min-h-screen">
            <!-- Top header for mobile -->
            <div class="sticky top-0 z-10 md:hidden">
                <!-- Mobile top bar is handled in mobile menu section -->
            </div>

            <!-- Main content area -->
            <main class="flex-1">
                <!-- Header with title -->
                @if(isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        <!-- THIS IS THE KEY PART - MAKE SURE TO RENDER THE SLOT HERE -->
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-gray-50 border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ date('Y') }} Home Services. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Chat Components for authenticated users -->
    @auth
        @if(!Auth::user()->isAdmin())
            <x-chat.button />
            <x-chat.box />
        @endif
    @endauth
</body>
</html>