<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\AddReplayRequest;
use App\Http\Requests\Message\LikeMessageRequest;
use App\Http\Requests\Message\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Jobs\NewMessageJob;
use App\Models\Message;
use App\Models\User;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function show(Message $message)
    {
        return Inertia::render('message/show', [
            'message' => new MessageResource($message),
        ]);
    }

    public function like(LikeMessageRequest $request)
    {
        try {
            $message = Message::findOrFail($request->message_id);
            if ($request->like === false) {
                $message->likes()->where('user_id', $request->user()->id)->delete();

                return response()->json(['message' => 'Unliked message successfully']);
            }
            $message->likes()->create([
                'user_id' => $request->user()->id,
            ]);

            return response()->json(['message' => 'Liked message successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to like'], 500);
        }
    }

    public function addReply(AddReplayRequest $request)
    {
        try {
            $message = Message::findOrFail($request->message_id);
            $message->replays()->create([
                'user_id' => $request->user()->id,
                'text' => $request->replay,
            ]);

            return response()->json(['message' => 'Reply added']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function sendMessage(SendMessageRequest $request)
    {
        try {
            $message = Message::create([
                'sender_id' => $request->user()->id,
                'user_id' => $request->receiver_id,
                'message' => $request->message,
                'is_anon' => false,
            ]);
            $recviedUser = User::findOrFail($request->receiver_id);
            NewMessageJob::dispatch($recviedUser, $request->user(), $message);

            return response()->json(['message' => 'Message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
