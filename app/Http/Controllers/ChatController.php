<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Get or create a conversation for the authenticated user
     */
    public function getUserConversation()
    {
        $user = Auth::user();
        
        // Get or create a conversation for the user
        $conversation = Conversation::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'open'],
            ['admin_id' => null] // We'll set admin_id when an admin responds
        );
        
        return response()->json([
            'conversation_id' => $conversation->id
        ]);
    }
    
    /**
     * Get messages for a specific conversation
     */
    public function getMessages($conversationId)
    {
        $user = Auth::user();
        
        // Verify the conversation belongs to the user
        $conversation = Conversation::where('id', $conversationId)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }
        
        // Mark admin messages as read
        Message::where('conversation_id', $conversationId)
            ->where('sender_role', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Get the messages
        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at')
            ->get()
            ->map(function($message) use ($user) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sent_by_me' => $message->sender_role === 'user',
                    'timestamp' => $message->created_at->diffForHumans(),
                ];
            });
        
        return response()->json($messages);
    }
    
    /**
     * Send a new message in the conversation
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string|max:1000',
        ]);
        
        $user = Auth::user();
        
        // Verify the conversation belongs to the user
        $conversation = Conversation::where('id', $request->conversation_id)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }
        
        try {
            // Create the message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_role' => 'user',
                'message' => $request->message,
                'is_read' => false,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sent_by_me' => true,
                    'timestamp' => $message->created_at->diffForHumans(),
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to save message'
            ], 500);
        }
    }
}