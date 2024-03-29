<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get All Users
     */
    public function getAllUsers(): Collection;

    /**
     * Get User By Id
     */
    public function getUserById(int $id): User;

    /**
     * Create User
     */
    public function createUser(array $data): User;

    /**
     * Update User
     */
    public function updateUser(int $id, array $data): bool;

    /**
     * Delete User
     */
    public function deleteUser(int $id): int;
}
