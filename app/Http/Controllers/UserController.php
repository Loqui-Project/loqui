<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function profile(Request $request, User $user)
    {

        $is_me = $request->user()?->is($user);
        $messages = $user->messages()->with('user')->withReplies()->latest()->get();

        return Inertia::render('profile', [
            'user' => $user,
            'is_me' => $is_me,
            'messages' => MessageResource::collection($messages),
            'is_following' => $request->user()?->isFollowing($user),
        ]);
    }

    public function follow(Request $request)
    {
        try {
            UserFollow::create([
                'user_id' => $request->user_id,
                'follower_id' => $request->user()->id,
            ]);

            return response()->json(['message' => 'Followed successfully']);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function unfollow(Request $request)
    {
        try {
            UserFollow::where('user_id', $request->user_id)
                ->where('follower_id', $request->user()->id)
                ->delete();

            return response()->json(['message' => 'Unfollowed successfully']);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
