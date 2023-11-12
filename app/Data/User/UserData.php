<?php

namespace App\Data\User;

use App\Contracts\Data\HasWallet;
use App\Data\Wallet\WalletData;
use App\Models\User;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class UserData extends Data implements HasWallet
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password,
        public ?string $emailVerifiedAt = null,
        public ?WalletData $wallet = null,
    )
    {
    }

    public function getMorphClass(): string
    {
        return (new User())->getMorphClass();
    }
}
