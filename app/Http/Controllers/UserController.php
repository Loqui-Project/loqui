<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function profile(Request $request, User $user)
    {
        $is_me = $request->user()->is($user);
        $messages = $user->messages()->with('user')->withReplies()->latest()->get();
        return Inertia::render('profile', [
            'user' => $user,
            'is_me' => $is_me,
            'messages' => MessageResource::collection($messages),
        ]);
    }
}
