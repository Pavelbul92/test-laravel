<?php

namespace App\Data\Wallet;

use App\Models\Wallet\Wallet;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class WalletOperationData extends Data
{
    public function __construct(
        public int $id,
        public string $description,
        public float $value,
        public ?Carbon $createdAt,
        public ?Wallet $wallet = null,
    )
    {
    }
}
