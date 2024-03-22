<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get All Users
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Get User By Id
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User;

    /**
     * Create User
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Update User
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser(int $id, array $data): bool;

    /**
     * Delete User
     * @param int $id
     * @return int
     */
    public function deleteUser(int $id) : int;
}
