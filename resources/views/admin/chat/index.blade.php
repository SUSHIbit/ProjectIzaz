@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ __('Chat Management') }}
                </h2>
                
                @if($conversations->count() > 0)
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Message</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($conversations as $conversation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $conversation->user->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($conversation->latestMessage)
                                                    <span class="font-medium">{{ $conversation->latestMessage->sender_role === 'user' ? 'User: ' : 'Admin: ' }}</span>
                                                    {{ Str::limit($conversation->latestMessage->message, 50) }}
                                                    <div class="text-xs text-gray-500">
                                                        {{ $conversation->latestMessage->created_at->diffForHumans() }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-500">No messages yet</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $conversation->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($conversation->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.chat.show', $conversation->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            
                                            @if($conversation->status === 'open')
                                                <form class="inline" method="POST" action="{{ route('admin.chat.close', $conversation->id) }}" onsubmit="return confirm('Are you sure you want to close this conversation?')">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Close</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $conversations->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No conversations yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Wait for users to start a conversation.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection