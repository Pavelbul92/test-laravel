<?php

namespace App\Repositories;

use App\Contracts\Data\HasWallet;
use App\Data\Wallet\CreateWalletOperationData;
use App\Data\Wallet\WalletData;
use App\Data\Wallet\WalletOperationData;
use App\Data\Wallet\WalletOperationsListParamsData;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletOperation;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class WalletRepository
{
    public function store(HasWallet $modelData): WalletData
    {
        return WalletData::from(Wallet::query()->create([
            'model_type' => $modelData->getMorphClass(),
            'model_id' => $modelData->id,
            'current_balance' => 0
        ]));
    }

    public function getOperationsList(WalletOperationsListParamsData $listParamsData): PaginatedDataCollection
    {
        $query = WalletOperation::query()->orderBy($listParamsData->orderBy->value, $listParamsData->sortBy->name);

        if ($listParamsData->filter){
            if ($listParamsData->filter->walletID){
                $query->where('wallet_id', $listParamsData->filter->walletID);
            }

            if ($listParamsData->filter->search){
                $query->where('description', 'LIKE', '%'.$listParamsData->filter->search.'%');
            }
        }

        return WalletOperationData::collection($query->paginate(
            $listParamsData->limit,
            '*',
            'page',
            $listParamsData->page
        ));
    }

    public function getById(int $walletID): ?WalletData
    {
        $wallet = Wallet::query()->find($walletID);
        if ($wallet){
            return WalletData::from($wallet);
        }

        return null;
    }

    public function storeWalletOperation(CreateWalletOperationData $createWalletOperationData): WalletOperationData
    {
        return WalletOperationData::from(WalletOperation::query()->create([
            'wallet_id' => $createWalletOperationData->walletID,
            'description' => $createWalletOperationData->description,
            'value' => $createWalletOperationData->value
        ]));
    }

    public function updateWalletCurrentBalance(int $walletID): void
    {
        $sum = WalletOperation::query()->sum('value');
        Wallet::query()->where('id', $walletID)->update(['current_balance' => $sum]);
    }
}
