<?php

namespace App\Services;

use App\Data\User\CreateUserData;
use App\Data\User\UserData;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected WalletService $walletService,
    )
    {
    }

    public function create(CreateUserData $createUserData): UserData
    {
        return $this->userRepository->store($createUserData);
    }


    public function createWithWallet(CreateUserData $createUserData): UserData
    {
        return DB::transaction(function () use ($createUserData){
            $createdUser = $this->create($createUserData);
            $createdUser->wallet = $this->walletService->create($createdUser);
            return $createdUser;
        });
    }

}
