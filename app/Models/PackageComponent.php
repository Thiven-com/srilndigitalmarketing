<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageComponent extends Model
{
    protected $fillable = [
        'package_id',
        'component_type',
        'name',
        'code',
        'calculation_type',
        'amount',
        'percentage',
        'level',
        'minimum_amount',
        'maximum_amount',
        'is_mandatory',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_amount' => 'decimal:2',

        'level' => 'integer',
        'sort_order' => 'integer',

        'is_mandatory' => 'boolean',
        'status' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}