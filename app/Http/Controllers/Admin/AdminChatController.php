<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['user', 'latestMessage'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
            
        return view('admin.chat.index', compact('conversations'));
    }
    
    public function show($id)
    {
        $conversation = Conversation::with('user')->findOrFail($id);
        
        // Mark user messages as read
        Message::where('conversation_id', $id)
            ->where('sender_role', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return view('admin.chat.show', compact('conversation'));
    }
    
    public function getMessages($conversationId)
    {
        // Verify the conversation exists
        $conversation = Conversation::findOrFail($conversationId);
        
        // Get the messages
        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at')
            ->get()
            ->map(function($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sent_by_me' => $message->sender_role === 'admin',
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
        
        // Create the message
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_role' => 'admin',
            'message' => $request->message,
        ]);
        
        // Update the admin ID if not already set
        $conversation = Conversation::find($request->conversation_id);
        if (!$conversation->admin_id) {
            $conversation->admin_id = Auth::id();
            $conversation->save();
        }
        
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
    
    public function closeConversation($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->status = 'closed';
        $conversation->save();
        
        return redirect()->route('admin.chat.index')->with('success', 'Conversation closed successfully');
    }
}