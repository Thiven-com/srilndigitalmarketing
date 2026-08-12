<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiveWayDirectReferral extends Model
{
    use HasFactory;

    protected $table = 'five_way_direct_referrals';

    protected $fillable = [
        'customer_id',
        'userId',
        'sponser_id',
        'placedunder_id',

        'left_points',
        'right_points',
        'total_income',

        'last_settled_at',

        'rootmap',
        'presenttime',

        'points',
        'edate',

        'g_count',
        'g_reff',

        'placedunderid_cnt',
        'cron_start',
        'cron_end',
    ];

    protected $casts = [
        'left_points' => 'decimal:6',
        'right_points' => 'decimal:6',
        'total_income' => 'decimal:2',

        'last_settled_at' => 'datetime',
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
}