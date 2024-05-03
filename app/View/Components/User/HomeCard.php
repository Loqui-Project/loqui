<?php

namespace App\View\Components\User;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class HomeCard extends Component
{

    protected $shareData = [];

    /**
     * Create a new component instance.
     */
    public function __construct(protected User $user)
    {
        //
    }

    public function getFollowersCountProperty(): int
    {
        return Cache::remember(
            "user:{$this->user->id}:followers_count",
            3600 * 6,
            function () {
                return $this->user->follower()->count();
            }
        );
    }

    public function getFollowingCountProperty(): int
    {
        return Cache::remember(
            "user:{$this->user->id}:following_count",
            3600 * 6,
            function () {
                return $this->user->following()->count();
            }
        );
    }

    public function getMessagesCountProperty(): int
    {
        return Cache::remember(
            "user:{$this->user->id}:messages_count",
            3600 * 6,
            function () {
                return $this->user->messages()->count();
            }
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->shareData["url"] = route('profile.user', $this->user->username);
        $this->shareData["avatar"] = URL::asset($this->user->mediaObject->media_path);
        $this->shareData["name"] = $this->user->name;
        return view('components.user.home-card', [
            'user' => $this->user,
            'followersCount' => $this->getFollowersCountProperty(),
            'followingCount' => $this->getFollowingCountProperty(),
            'messagesCount' => $this->getMessagesCountProperty(),
            'shareData' => json_encode($this->shareData),
        ]);
    }
}
