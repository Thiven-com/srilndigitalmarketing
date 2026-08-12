<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'price',
        'joining_amount',
        'renewal_amount',
        'short_description',
        'description',
        'image',
        'icon',
        'is_popular',
        'is_featured',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'joining_amount' => 'decimal:2',
        'renewal_amount' => 'decimal:2',

        'is_popular' => 'boolean',
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];

    public function levels()
    {
        return $this->hasMany(PackageLevel::class)
            ->orderBy('level');
    }

    public function components()
    {
        return $this->hasMany(PackageComponent::class)
            ->orderBy('sort_order');
    }
}