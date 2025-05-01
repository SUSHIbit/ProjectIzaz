<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getUserConversation()
    {
        $user = Auth::user();
        
        // Get or create a conversation for the user
        $conversation = Conversation::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'open'],
            ['admin_id' => 1] // hardcoded admin ID as requested
        );
        
        return response()->json([
            'conversation_id' => $conversation->id
        ]);
    }
    
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
        
        // Create the message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_role' => 'user',
            'message' => $request->message,
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
    }
}