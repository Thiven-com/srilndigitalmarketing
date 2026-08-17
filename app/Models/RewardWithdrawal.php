<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardWithdrawal extends Model
{
    protected $fillable = [

        'customer_id',

        'requested_amount',

        'deduction_percentage',

        'deduction_amount',

        'payable_amount',

        'opening_rewards',

        'closing_rewards',

        'payment_method',

        'payment_reference',

        'admin_remark',

        'status',

        'approved_at',

    ];


    protected $casts = [

        'requested_amount' => 'decimal:2',

        'deduction_percentage' => 'decimal:2',

        'deduction_amount' => 'decimal:2',

        'payable_amount' => 'decimal:2',

        'opening_rewards' => 'decimal:2',

        'closing_rewards' => 'decimal:2',

        'approved_at' => 'datetime',

    ];


    public function customer()
    {
        return $this->belongsTo(
            Customer::class
        );
    }
}