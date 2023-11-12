<?php

namespace App\Http\Controllers;

use App\Data\Wallet\WalletOperationsListFilterParams;
use App\Data\Wallet\WalletOperationsListParamsData;
use App\Enums\SortByType;
use App\Enums\Wallet\Operation\OrderByColumnType;
use App\Models\User;
use App\Repositories\WalletRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WalletController extends Controller
{
    public function __construct(protected WalletRepository $walletRepository)
    {
    }

    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $wallet = $this->walletRepository->getById($user->wallet->id);


        return Inertia::render('Wallet/Index', [
            'wallet' => $wallet,
            'operationsPaginated' => $this->walletRepository->getOperationsList(new WalletOperationsListParamsData(
                orderBy: !empty($request->get('orderBy')) ? OrderByColumnType::from($request->get('orderBy')) : OrderByColumnType::DATE,
                sortBy: !empty($request->get('sortBy')) ? SortByType::from($request->get('sortBy')) : SortByType::DESC,
                page: 1,
                //TODO make pagination on frontend
                limit: 500,
                filter: new WalletOperationsListFilterParams(
                    walletID: $wallet->id,
                    search: $request->get('filter')['search'] ?? null
                )
            ))
        ]);
    }
}
