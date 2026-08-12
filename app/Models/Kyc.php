<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;

    protected $table = 'kycs';

    protected $fillable = [
        'user_id',
        'user_role',

        'aadhaar_no',
        'aadhaar_image',
        'aadhaar_verified_at',
        'aadhar_status',

        'pan_no',
        'pan_verified_at',
        'pan_status',

        'gst',
        'gst_name',
        'gst_address',
        'gst_type',
        'gst_image',
        'gst_status',
    ];

    protected $casts = [
        'aadhaar_verified_at' => 'datetime',
        'pan_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(
            Customer::class,
            'user_id'
        );
    }
}