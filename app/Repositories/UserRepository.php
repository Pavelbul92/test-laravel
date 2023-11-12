<?php

namespace App\Repositories;

use App\Data\User\CreateUserData;
use App\Data\User\UserData;
use App\Models\User;

class UserRepository
{
    public function findUserWithWalletByEmail(string $userEmail): ?UserData
    {
        $user = User::query()->with(['wallet'])->where('email', $userEmail)->first();

        if ($user){
            return UserData::from($user);
        }

        return null;
    }

    public function store(CreateUserData $createUserData): UserData
    {
        return UserData::from(User::query()->create([
            'name' => $createUserData->name,
            'email' => $createUserData->email,
            'password' => $createUserData->password,
        ]));
    }
}
