<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'package_id',
        'order_number',

        'package_amount',
        'joining_amount',
        'total_amount',

        'payment_method',
        'payment_reference',
        'payment_receipt',

        'payment_status',
        'package_status',

        'approved_by',
        'approved_at',
        'rejected_at',

        'admin_remark',
        'activated_at',
    ];

    protected $casts = [
        'package_amount' => 'decimal:2',
        'joining_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',

        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'activated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Package
    |--------------------------------------------------------------------------
    */

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Approved By
    |--------------------------------------------------------------------------
    */

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}