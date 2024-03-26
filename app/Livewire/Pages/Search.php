<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Search extends Component
{

    public $search = "";

    public $users;



    public function mount()
    {
        $this->users = User::withCount(["messages" => function ($query) {
            $query->whereHas("replay");
        }])->where("id", "!=", Auth::user()->id)->get();
    }

    public function updatedSearch()
    {
        $this->users = User::whereAny(
            ["name", "email", "username"],
            "LIKE",
            "%{$this->search}%"
        )
            ->withCount(["messages" => function ($query) {
                $query->whereHas("replay");
            }])->get();
    }




    public function render()
    {
        return view('livewire.pages.search', [
            "users" => $this->users
        ])->extends('components.layouts.app');
    }
}
