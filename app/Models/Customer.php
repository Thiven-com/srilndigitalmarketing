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

        /*
        |--------------------------------------------------------------------------
        | Customer Details
        |--------------------------------------------------------------------------
        */

        'userid',

        'name',

        'old_name',

        'email',

        'mobile',


        /*
        |--------------------------------------------------------------------------
        | Sponsor / Tree
        |--------------------------------------------------------------------------
        */

        'sponsor_id',

        'sponsor_name',

        'activation',

        'placedunder_id',

        'position',

        'rootmap',


        /*
        |--------------------------------------------------------------------------
        | Wallet / Rewards
        |--------------------------------------------------------------------------
        */

        'wallet',

        'bonus',

        'rewards',


        /*
        |--------------------------------------------------------------------------
        | Personal Details
        |--------------------------------------------------------------------------
        */

        'dob',

        'otp',

        'latitude',

        'longitude',


        /*
        |--------------------------------------------------------------------------
        | KYC
        |--------------------------------------------------------------------------
        */

        'kyc_status',


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        'profile_pic',


        /*
        |--------------------------------------------------------------------------
        | Verification
        |--------------------------------------------------------------------------
        */

        'mobile_verified',

        'email_verified',

        'mobile_verified_at',

        'email_verified_at',


        /*
        |--------------------------------------------------------------------------
        | Firebase / Authentication
        |--------------------------------------------------------------------------
        */

        'firebase_token',

        'remember_token',


        /*
        |--------------------------------------------------------------------------
        | Account Status
        |--------------------------------------------------------------------------
        */

        'is_verify',

        'is_block',

        'is_deleted',

        'account_status',
    ];


    protected $hidden = [
        'otp',
        'remember_token',
    ];


    protected $casts = [

        /*
        |--------------------------------------------------------------------------
        | Dates
        |--------------------------------------------------------------------------
        */

        'dob' => 'date',

        'mobile_verified_at' => 'datetime',

        'email_verified_at' => 'datetime',


        /*
        |--------------------------------------------------------------------------
        | Money
        |--------------------------------------------------------------------------
        */

        'wallet' => 'decimal:2',

        'bonus' => 'decimal:2',

        'rewards' => 'decimal:2',


        /*
        |--------------------------------------------------------------------------
        | Location
        |--------------------------------------------------------------------------
        */

        'latitude' => 'decimal:8',

        'longitude' => 'decimal:8',
    ];
}