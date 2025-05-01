<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chat with') }} {{ $conversation->user->name }}
            </h2>
            <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                Back to Conversations
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="adminChat({{ $conversation->id }})" x-init="initChat">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-medium">Conversation with {{ $conversation->user->name }}</h3>
                        <p class="text-sm text-blue-200">{{ $conversation->user->email }}</p>
                    </div>
                    <div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $conversation->status === 'open' ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ ucfirst($conversation->status) }}
                        </span>
                    </div>
                </div>
                
                <!-- Chat Messages -->
                <div id="admin-chat-messages" class="p-6 h-96 overflow-y-auto space-y-4">
                    <div class="text-center text-sm text-gray-500">
                        Loading messages...
                    </div>
                </div>
                
                <!-- Chat Input -->
                <div class="border-t p-6" x-show="'{{ $conversation->status }}' === 'open'">
                    <form @submit.prevent="sendMessage" class="flex space-x-2">
                        <input type="text" 
                               x-model="newMessage" 
                               placeholder="Type your message..." 
                               class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none">
                            Send
                        </button>
                    </form>
                </div>
                
                <div class="p-6 border-t bg-gray-50" x-show="'{{ $conversation->status }}' === 'closed'">
                    <div class="text-center text-gray-600">
                        This conversation is closed. 
                        <form class="inline-block" method="POST" action="{{ route('admin.chat.close', $conversation->id) }}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="text-blue-600 underline">Reopen conversation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function adminChat(conversationId) {
        return {
            conversationId: conversationId,
            newMessage: '',
            messages: [],
            refreshInterval: null,
            
            initChat() {
                this.loadMessages();
                this.startPolling();
            },
            
            loadMessages() {
                fetch(`/admin/chat/${this.conversationId}/messages`)
                    .then(response => response.json())
                    .then(data => {
                        this.messages = data;
                        this.renderMessages();
                        this.scrollToBottom();
                    });
            },
            
            renderMessages() {
                const container = document.getElementById('admin-chat-messages');
                container.innerHTML = '';
                
                if (this.messages.length === 0) {
                    const emptyMessage = document.createElement('div');
                    emptyMessage.className = 'text-center text-sm text-gray-500';
                    emptyMessage.textContent = 'No messages yet. Start the conversation!';
                    container.appendChild(emptyMessage);
                    return;
                }
                
                this.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${message.sent_by_me ? 'justify-end' : 'justify-start'}`;
                    
                    const innerDiv = document.createElement('div');
                    innerDiv.className = message.sent_by_me 
                        ? 'bg-blue-600 text-white rounded-lg py-2 px-4 max-w-md'
                        : 'bg-gray-200 rounded-lg py-2 px-4 max-w-md';
                        
                    const messageText = document.createElement('p');
                    messageText.className = 'text-sm';
                    messageText.textContent = message.message;
                    
                    const timestamp = document.createElement('div');
                    timestamp.className = message.sent_by_me 
                        ? 'text-xs text-blue-200 mt-1'
                        : 'text-xs text-gray-500 mt-1';
                    timestamp.textContent = message.timestamp;
                    
                    innerDiv.appendChild(messageText);
                    innerDiv.appendChild(timestamp);
                    messageDiv.appendChild(innerDiv);
                    container.appendChild(messageDiv);
                });
            },
            
            sendMessage() {
                if (!this.newMessage.trim()) return;
                
                const message = this.newMessage;
                this.newMessage = '';
                
                fetch('/admin/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        conversation_id: this.conversationId,
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.messages.push(data.message);
                        this.renderMessages();
                        this.scrollToBottom();
                    }
                });
            },
            
            startPolling() {
                this.refreshInterval = setInterval(() => {
                    this.loadMessages();
                }, 3000);
            },
            
            scrollToBottom() {
                setTimeout(() => {
                    const chatMessages = document.getElementById('admin-chat-messages');
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 100);
            }
        }
    }
    </script>
</x-app-layout>