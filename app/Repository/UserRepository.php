<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function store(array $data): User
    {
        return User::create($data);
    }

    public function getUser($userId): User
    {
        return User::findOrFail($userId);
    }
    public function getUserByEmail($email): User
    {
        return User::firstWhere(User::EMAIL, $email);
    }
    public function markEmailVerified($userId): User|null
    {
        $user = User::find($userId);
        $isVerified = $user->markEmailAsVerified();
        if ($isVerified) {
            return User::findOrFail($userId);
        }

        return null;
    }

    public function update(array $data, $userId): User
    {
        $user = User::findOrFail($userId);
        $user->update($data);
        return $this->getUser($userId);
    }

}
