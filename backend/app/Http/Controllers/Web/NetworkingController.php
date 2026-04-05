<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Connection;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class NetworkingController extends Controller
{
    public function index(): View
    {
        return view('networking.index');
    }

    public function connections(): View
    {
        $user = auth()->user();
        $connections = $user->connections()->with('receiver')->paginate(20);
        return view('networking.connections', compact('connections'));
    }

    public function sendRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id|different:' . auth()->id(),
        ]);

        Connection::updateOrCreate(
            [
                'sender_id' => auth()->id(),
                'receiver_id' => $validated['receiver_id'],
            ],
            ['status' => 'pending']
        );

        return back()->with('success', 'Connection request sent!');
    }

    public function acceptRequest(Connection $connection): RedirectResponse
    {
        if ($connection->receiver_id !== auth()->id()) {
            abort(403);
        }

        $connection->update(['status' => 'accepted']);
        return back()->with('success', 'Connection accepted!');
    }

    public function rejectRequest(Connection $connection): RedirectResponse
    {
        if ($connection->receiver_id !== auth()->id()) {
            abort(403);
        }

        $connection->delete();
        return back()->with('success', 'Connection rejected!');
    }

    public function messages(): View
    {
        $user = auth()->user();
        $conversations = $user->conversations()->latest()->paginate(20);
        return view('networking.messages', compact('conversations'));
    }

    public function conversation(User $user): View
    {
        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        return view('networking.conversation', compact('user', 'messages'));
    }

    public function sendMessage(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message sent!');
    }
}
