<?php

namespace App\Models\Traits;

use App\Models\Wallet\Wallet;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasWalletTrait
{
    public function wallet(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'model');
    }
}
