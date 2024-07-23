<?php

namespace App\DataObjectTransfert;

use App\Models\User;

class UserData
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly ?string $role,

    ) {
    }

    public function toArray()
    {
        return [
            User::NAME => $this->name,
            User::EMAIL => $this->email,
            User::PASSWORD => $this->password,
            User::ROLE => $this->role,
        ];
    }
}
