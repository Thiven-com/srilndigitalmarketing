<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'user_role',
        'account_name',
        'bank_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'account_type',
        'bank_status',
        'upi_id',
        'upi_status',
    ];
}
