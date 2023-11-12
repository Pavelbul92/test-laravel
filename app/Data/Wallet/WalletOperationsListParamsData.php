<?php

namespace App\Data\Wallet;

use App\Enums\SortByType;
use App\Enums\Wallet\Operation\OrderByColumnType;
use Spatie\LaravelData\Data;

class WalletOperationsListParamsData extends Data
{
    public function __construct(
        public ?OrderByColumnType $orderBy = OrderByColumnType::DATE,
        public ?SortByType $sortBy = SortByType::DESC,
        public ?int $page = 1,
        public ?int $limit = 5,
        public ?WalletOperationsListFilterParams $filter = null,
    )
    {
    }
}
