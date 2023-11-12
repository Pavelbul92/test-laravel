<?php

namespace App\Data\Wallet;

use Spatie\LaravelData\Data;

class CreateWalletOperationData extends Data
{
    public function __construct(
        public int $walletID,
        public string $description,
        public float $value,
    )
    {
    }
}
