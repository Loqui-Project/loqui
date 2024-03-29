<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    public function getUserById(int $id): User
    {
        return User::find($id);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        return User::where('id', $id)->update($data);
    }

    public function deleteUser(int $id): int
    {
        return User::destroy($id);
    }
}
