<?php

namespace App\Livewire\Component\User;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SearchUserCard extends Component
{

    public User $user;

    public bool $isFollowing = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->isFollowing = Auth::user()->following->contains($user);
    }
    public function follow($id)
    {
        $user = User::find($id);

        /* @var User $currentUser */
        $currentUser = Auth::user();
        if ($this->isFollowing) {
            UserFollow::where([
                "follower_id" => $currentUser->id,
                "following_id" => $user->id
            ])->delete();
            $this->isFollowing = false;
        } else {

            UserFollow::create([
                "follower_id" => $currentUser->id,
                "following_id" => $user->id
            ]);
            $this->isFollowing = true;
        }
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.component.user.search-user-card', [
            "user" => $this->user,
            "isFollowing" => $this->isFollowing
        ]);
    }
}
