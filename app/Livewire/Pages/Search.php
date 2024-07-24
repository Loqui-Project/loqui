<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Search extends Component
{
    use WithoutUrlPagination, WithPagination;

    public $search = '';

    public int $perPage = 5;

    public function loadMore()
    {
        $this->perPage = $this->perPage + 5;
    }

    #[Computed]
    public function userMessages()
    {
        $key = "search:{$this->search}:{$this->perPage}";
        $seconds = now()->addHours(4); // 1 hour...

        return Cache::remember($key, $seconds, function () {
            return User::whereAny(
                ['name', 'email', 'username'],
                'LIKE',
                "%{$this->search}%",
            )
                ->withCount([
                    'messages' => function ($query) {
                        $query->whereHas('replay');
                    },
                ])
                ->where('id', '!=', Auth::id())
                ->orderBy('messages_count', 'desc')
                ->paginate($this->perPage);
        });
    }

    public function render()
    {
        return view('livewire.pages.search', [
            'users' => $this->userMessages(),
        ])->extends('components.layouts.app');
    }
}
