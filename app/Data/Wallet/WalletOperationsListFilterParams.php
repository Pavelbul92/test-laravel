<?php

namespace App\Data\Wallet;

use Spatie\LaravelData\Data;

class WalletOperationsListFilterParams extends Data
{
    public function __construct(
        public ?int $walletID = null,
        public ?string $search = null
    )
    {
    }
}
