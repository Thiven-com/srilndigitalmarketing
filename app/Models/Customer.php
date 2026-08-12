<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'mobile',

        'wallet',
        'rewards',

        'dob',

        'otp',

        'latitude',
        'longitude',

        'kyc_status',

        'profile_pic',

        'mobile_verified',
        'email_verified',

        'mobile_verified_at',
        'email_verified_at',

        'firebase_token',

        'remember_token',

        'is_verify',
        'is_block',

        'account_status',
    ];

    protected $hidden = [
        'otp',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',

        'wallet' => 'decimal:2',
        'rewards' => 'decimal:2',

        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',

        'mobile_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];
}