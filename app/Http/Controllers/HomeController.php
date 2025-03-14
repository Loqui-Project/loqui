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

        // get messages for users that i follow them
        $followingUsersId = $request->user()->followings()->get()->pluck('user_id')->flatten();
        $messages = Message::whereIn('user_id', [
            ...$followingUsersId,
            $request->user()->id,
        ])->latest()->get();

        return Inertia::render('home', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
            'messages' => MessageResource::collection($messages),
        ]);
    }
}
