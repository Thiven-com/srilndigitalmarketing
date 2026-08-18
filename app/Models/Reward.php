<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'rewards';

    protected $fillable = [
        'user_id',
        'package_id',
        'role',
        'activity_id',
        'source_type',
        'source_id',
        'reward_type',
        'transaction_type',
        'amount',
        'opening_balance',
        'closing_balance',
        'description',
        'status',
        'is_reverted',
        'meta_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'meta_data' => 'array',
    ];

    /**
     * Reward belongs to a customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

}