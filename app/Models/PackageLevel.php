<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageLevel extends Model
{
    protected $fillable = [
        'package_id',
        'level',
        'name',
        'calculation_type',
        'amount',
        'percentage',
        'minimum_business',
        'maximum_income',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'level' => 'integer',

        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',

        'minimum_business' => 'decimal:2',
        'maximum_income' => 'decimal:2',

        'sort_order' => 'integer',

        'status' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}