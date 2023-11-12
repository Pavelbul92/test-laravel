<?php

namespace App\Console\Commands\System\Wallet;

use App\Data\Wallet\CreateWalletOperationData;
use App\Exceptions\Services\WalletServiceException;
use App\Jobs\WalletMakeOperation;
use App\Repositories\UserRepository;
use App\Services\WalletService;
use Illuminate\Console\Command;

class MakeOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:operation {--Q|queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        WalletService  $walletService,
        UserRepository $userRepository,
    )
    {
        $forModel = $this->choice('Which model do you want to perform the operation on?', [
            'User'
        ]);

        $wallet = null;

        if ($forModel === 'User') {
            $user = null;
            while (!$user) {
                $userEmail = $this->ask('Enter user email');
                $user = $userRepository->findUserWithWalletByEmail($userEmail);
                if (!$user) {
                    $this->warn('User not found. Retry or ctrl + C for exit');
                }
            }

            $wallet = $user->wallet;
        }

        $description = $this->ask('Please enter operation description.');

        $operationCompleted = false;

        while (!$operationCompleted){
            $value = $this->ask('Enter operation value');
            $walletOperation = new CreateWalletOperationData(
                walletID: $wallet->id,
                description: $description,
                value: $value,
            );

            try {
                if ($this->option('queue')){
                    WalletMakeOperation::dispatch($walletOperation);
                    $this->info('Operation sent in queue.');
                    return self::SUCCESS;
                } else {
                    $walletService->makeWalletOperation($walletOperation);
                }

                $operationCompleted = true;
            } catch (WalletServiceException $walletServiceException){
                $this->error($walletServiceException->getMessage());
            } catch (\Throwable $throwable) {
                $this->error($throwable->getMessage());
                return self::FAILURE;
            }
        }

        $this->info('Operation completed.');

        return self::SUCCESS;
    }


}
