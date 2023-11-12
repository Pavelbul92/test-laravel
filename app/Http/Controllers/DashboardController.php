<?php

namespace App\Http\Controllers;

use App\Data\Wallet\WalletOperationsListFilterParams;
use App\Data\Wallet\WalletOperationsListParamsData;
use App\Enums\SortByType;
use App\Enums\Wallet\Operation\OrderByColumnType;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(protected WalletRepository $walletRepository)
    {
    }

    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $wallet = $this->walletRepository->getById($user->wallet->id);

        return Inertia::render('Dashboard', [
            'wallet' => $wallet,
            'operationsPaginated' => $this->walletRepository->getOperationsList(new WalletOperationsListParamsData(
                filter: new WalletOperationsListFilterParams(
                    walletID: $wallet->id
                )
            ))
        ]);
    }
}
