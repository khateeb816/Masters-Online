<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $inbox = Message::forUser(Auth::id())
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $sent = Message::sentByUser(Auth::id())
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pages.messages.index', compact('inbox', 'sent'));
    }





    public function show($id)
    {
        $message = Message::where(function($query) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })->with(['sender', 'receiver'])->findOrFail($id);

        if ($message->receiver_id == Auth::id() && !$message->is_read) {
            $message->markAsRead();
        }

        return view('pages.messages.show', compact('message'));
    }



    public function markAsRead($id)
    {
        $message = Message::forUser(Auth::id())->findOrFail($id);
        $message->markAsRead();

        return redirect()->back()->with('success', 'Message marked as read');
    }

    public function destroy($id)
    {
        $message = Message::where(function($query) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })->findOrFail($id);

        $message->deleteForUser(Auth::id());

        return redirect()->route('messages')->with('success', 'Message deleted successfully');
    }

    public function getUnreadCount()
    {
        $count = Message::forUser(Auth::id())->unread()->count();
        return response()->json(['count' => $count]);
    }

    public function getRecentMessages()
    {
        $messages = Message::forUser(Auth::id())
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($messages);
    }
}
