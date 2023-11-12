<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $current_balance
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'current_balance',
    ];
}
