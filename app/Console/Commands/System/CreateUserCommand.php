<?php

namespace App\Console\Commands\System;

use App\Data\User\CreateUserData;
use App\Data\User\UserData;
use App\Services\UserService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates user';

    /**
     * Execute the console command.
     */
    public function handle(UserService $userService)
    {
        try {
            $createdUser = $userService->createWithWallet(new CreateUserData(
                $this->argument('name'),
                $this->argument('email'),
                $this->argument('password')
            ));

            $this->info('User has been created. Id:'.$createdUser->id);

        } catch (Throwable $throwable){
            $this->error($throwable->getMessage());
        }

        return CommandAlias::FAILURE;
    }
}
