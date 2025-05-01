<!-- resources/views/components/chat/box.blade.php -->
@auth
<div id="chat-box" 
     class="fixed bottom-20 right-4 z-50 bg-white rounded-lg shadow-xl w-80 hidden overflow-hidden"
     x-data="chatBox()"
     x-init="initChat">
    
    <!-- Chat Header -->
    <div class="bg-blue-600 text-white px-4 py-3 flex justify-between items-center">
        <h3 class="font-medium">Chat with Support</h3>
        <div class="flex space-x-2">
            <button @click="minimizeChat" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Chat Messages -->
    <div id="chat-messages" 
         class="p-4 h-80 overflow-y-auto space-y-4">
        <template x-if="messages.length === 0">
            <div class="text-center text-sm text-gray-500">
                Start a conversation with us!
            </div>
        </template>
        
        <template x-for="message in messages" :key="message.id">
            <div :class="message.sent_by_me ? 'flex justify-end' : 'flex justify-start'">
                <div :class="message.sent_by_me ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'" class="rounded-lg px-4 py-2 max-w-[75%]">
                    <p x-text="message.message"></p>
                    <div class="text-xs mt-1" x-text="message.timestamp"></div>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Chat Input -->
    <div class="border-t p-4">
        <form @submit.prevent="sendMessage" class="flex space-x-2">
            <input type="text" 
                   x-model="newMessage" 
                   placeholder="Type your message..." 
                   class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
function chatBox() {
    return {
        conversationId: null,
        newMessage: '',
        messages: [],
        refreshInterval: null,
        
        initChat() {
            this.setupChatButton();
            this.getConversation();
        },
        
        setupChatButton() {
            const chatButton = document.getElementById('chat-button');
            if (chatButton) {
                chatButton.addEventListener('click', () => {
                    const chatBox = document.getElementById('chat-box');
                    if (chatBox) {
                        chatBox.classList.toggle('hidden');
                        if (!chatBox.classList.contains('hidden')) {
                            this.scrollToBottom();
                            this.startPolling();
                        } else {
                            this.stopPolling();
                        }
                    }
                });
            }
        },
        
        getConversation() {
            fetch('/chat/conversation')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to get conversation');
                    }
                    return response.json();
                })
                .then(data => {
                    this.conversationId = data.conversation_id;
                    this.loadMessages();
                })
                .catch(error => {
                    console.error('Error getting conversation:', error);
                });
        },
        
        loadMessages() {
            if (!this.conversationId) return;
            
            fetch(`/chat/messages/${this.conversationId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load messages');
                    }
                    return response.json();
                })
                .then(data => {
                    this.messages = data;
                    this.scrollToBottom();
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                });
        },
        
        sendMessage() {
            if (!this.newMessage.trim() || !this.conversationId) {
                if (!this.newMessage.trim()) {
                    // Don't show error for empty message, just return
                    return;
                }
                if (!this.conversationId) {
                    alert('Unable to send message. Please refresh the page and try again.');
                    return;
                }
            }
            
            const message = this.newMessage;
            this.newMessage = '';
            
            fetch('/chat/send', {
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
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to send message');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.messages.push(data.message);
                    this.scrollToBottom();
                } else {
                    // Handle error
                    alert('Failed to send message: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            });
        },
        
        startPolling() {
            this.refreshInterval = setInterval(() => {
                this.loadMessages();
            }, 3000);
        },
        
        stopPolling() {
            clearInterval(this.refreshInterval);
        },
        
        scrollToBottom() {
            setTimeout(() => {
                const chatMessages = document.getElementById('chat-messages');
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }, 100);
        },
        
        minimizeChat() {
            const chatBox = document.getElementById('chat-box');
            if (chatBox) {
                chatBox.classList.add('hidden');
                this.stopPolling();
            }
        }
    };
}
</script>
@endauth