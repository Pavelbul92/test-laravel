<?php

namespace App\Services;

use App\Contracts\Data\HasWallet;
use App\Data\Wallet\CreateWalletOperationData;
use App\Data\Wallet\WalletData;
use App\Data\Wallet\WalletOperationData;
use App\Exceptions\Services\WalletServiceException;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        protected WalletRepository $walletRepository
    )
    {
    }

    /**
     * @throws WalletServiceException
     */
    public function create(HasWallet $model): WalletData
    {
        if (empty($model->id)){
            throw new WalletServiceException('Cannot create wallet, model does not has id');
        }

        return $this->walletRepository->store($model);
    }


    public function makeWalletOperation(CreateWalletOperationData $createWalletOperationData): WalletOperationData
    {
        return DB::transaction(function () use ($createWalletOperationData){
            $operation = $this->storeWalletOperation($createWalletOperationData);
            $this->walletRepository->updateWalletCurrentBalance($createWalletOperationData->walletID);
            return $operation;
        });
    }


    /**
     * @throws WalletServiceException
     */
    protected function storeWalletOperation(CreateWalletOperationData $createWalletOperationData): WalletOperationData
    {
        $wallet = $this->walletRepository->getById($createWalletOperationData->walletID);

        if ($wallet->currentBalance + $createWalletOperationData->value < 0) {
            throw new WalletServiceException('Cannot create operation. Wallet balance cannot be less than 0');
        }

        return $this->walletRepository->storeWalletOperation($createWalletOperationData);
    }

}
