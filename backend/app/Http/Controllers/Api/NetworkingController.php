<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NetworkingController extends Controller
{
    /**
     * Get all connections
     */
    public function connections(Request $request)
    {
        $userId = $request->user()->id;

        $connections = Connection::with(['sender', 'receiver'])
            ->where(function($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->orderBy('accepted_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $connections
        ]);
    }

    /**
     * Get pending connection requests
     */
    public function pendingRequests(Request $request)
    {
        $requests = Connection::with(['sender', 'receiver'])
            ->where('receiver_id', $request->user()->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $requests
        ]);
    }

    /**
     * Send connection request
     */
    public function sendRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->receiver_id == $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect with yourself'
            ], 400);
        }

        // Check if connection already exists
        $existing = Connection::where(function($q) use ($request) {
            $q->where('sender_id', $request->user()->id)
              ->where('receiver_id', $request->receiver_id);
        })->orWhere(function($q) use ($request) {
            $q->where('sender_id', $request->receiver_id)
              ->where('receiver_id', $request->user()->id);
        })->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Connection request already exists'
            ], 400);
        }

        $connection = Connection::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Connection request sent',
            'data' => $connection
        ], 201);
    }

    /**
     * Accept connection request
     */
    public function acceptRequest($id)
    {
        $connection = Connection::findOrFail($id);

        if ($connection->receiver_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $connection->accept();

        return response()->json([
            'success' => true,
            'message' => 'Connection accepted',
            'data' => $connection
        ]);
    }

    /**
     * Reject connection request
     */
    public function rejectRequest($id)
    {
        $connection = Connection::findOrFail($id);

        if ($connection->receiver_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $connection->reject();

        return response()->json([
            'success' => true,
            'message' => 'Connection rejected'
        ]);
    }

    /**
     * Get all messages/conversations
     */
    public function messages(Request $request)
    {
        $userId = $request->user()->id;

        // Get unique conversations
        $conversations = Message::with(['sender', 'receiver'])
            ->where(function($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('is_deleted_by_sender', false);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('receiver_id', $userId)
                  ->where('is_deleted_by_receiver', false);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($userId) {
                return $message->sender_id == $userId 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function($messages) {
                return $messages->first();
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $conversations
        ]);
    }

    /**
     * Get conversation with specific user
     */
    public function conversation(Request $request, $userId)
    {
        $messages = Message::with(['sender', 'receiver'])
            ->between($request->user()->id, $userId)
            ->where(function($q) use ($request, $userId) {
                $q->where(function($q2) use ($request) {
                    $q2->where('sender_id', $request->user()->id)
                       ->where('is_deleted_by_sender', false);
                })->orWhere(function($q2) use ($request) {
                    $q2->where('receiver_id', $request->user()->id)
                       ->where('is_deleted_by_receiver', false);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('receiver_id', $request->user()->id)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Send message
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'attachments' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'attachments' => $request->attachments,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent',
            'data' => $message->load(['sender', 'receiver'])
        ], 201);
    }

    /**
     * Delete message
     */
    public function deleteMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $userId = $request->user()->id;

        if ($message->sender_id === $userId) {
            $message->deleteForSender();
        } elseif ($message->receiver_id === $userId) {
            $message->deleteForReceiver();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Message deleted'
        ]);
    }

    /**
     * Get unread messages count
     */
    public function unreadCount(Request $request)
    {
        $count = Message::where('receiver_id', $request->user()->id)
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'data' => ['count' => $count]
        ]);
    }
}
