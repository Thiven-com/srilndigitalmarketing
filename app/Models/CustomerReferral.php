<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReferral extends Model
{
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

    public function customer()
    {
        return $this->belongsTo(
            Customer::class,
            'customer_id'
        );
    }
}