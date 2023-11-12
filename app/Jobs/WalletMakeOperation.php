<?php

namespace App\Jobs;

use App\Data\Wallet\CreateWalletOperationData;
use App\Services\WalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WalletMakeOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public CreateWalletOperationData $createWalletOperationData)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(WalletService $walletService): void
    {
        $walletService->makeWalletOperation($this->createWalletOperationData);
    }
}
