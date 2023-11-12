<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletOperation extends Model
{
    use HasFactory;

    protected $fillable = [
      'wallet_id',
      'description',
      'value'
    ];
}
