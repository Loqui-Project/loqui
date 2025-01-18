<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Search extends Component
{
    use WithoutUrlPagination, WithPagination;

    public $search = '';

    public int $perPage = 5;

    public function loadMore(): void
    {
        $this->perPage += 5;
    }

    #[Computed]
    public function userMessages()
    {
        $users = User::search(
            $this->search,

        );

        return $users->paginate($this->perPage);
    }

    #[Layout('components.layouts.app')]
    #[Title('Search')]
    public function render()
    {
        return view('livewire.pages.search', [
            'users' => $this->userMessages(),
        ]);
    }
}
