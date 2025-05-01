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
        <div class="text-center text-sm text-gray-500">
            Start a conversation with us!
        </div>
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
            document.getElementById('chat-button').addEventListener('click', () => {
                document.getElementById('chat-box').classList.toggle('hidden');
                if (!document.getElementById('chat-box').classList.contains('hidden')) {
                    this.scrollToBottom();
                    this.startPolling();
                } else {
                    this.stopPolling();
                }
            });
        },
        
        getConversation() {
            fetch('/chat/conversation')
                .then(response => response.json())
                .then(data => {
                    this.conversationId = data.conversation_id;
                    this.loadMessages();
                });
        },
        
        loadMessages() {
            if (!this.conversationId) return;
            
            fetch(`/chat/messages/${this.conversationId}`)
                .then(response => response.json())
                .then(data => {
                    this.messages = data;
                    this.scrollToBottom();
                });
        },
        
        sendMessage() {
            if (!this.newMessage.trim() || !this.conversationId) return;
            
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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.messages.push(data.message);
                    this.scrollToBottom();
                }
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
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 100);
        },
        
        minimizeChat() {
            document.getElementById('chat-box').classList.add('hidden');
            this.stopPolling();
        }
    }
}
</script>
@endauth