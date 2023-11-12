<?php

namespace App\Data\Wallet;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class WalletData extends Data
{
    public function __construct(
        public int $id,
        public float $currentBalance = 0,
    )
    {
    }
}
