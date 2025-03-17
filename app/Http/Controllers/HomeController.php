<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $followingUsersId = $request->user()->followings()->get()->pluck('user_id')->flatten();
        $messages = Message::whereIn('user_id', [
            ...$followingUsersId,
            $request->user()->id,
        ])->withReplies()->latest()->paginate();

        if (request()->wantsJson()) {
            return MessageResource::collection($messages);
        }

        return Inertia::render('home', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
            'messages' => MessageResource::collection($messages),
        ]);
    }
}
