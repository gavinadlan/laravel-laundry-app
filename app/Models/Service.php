<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Service represents a laundry service offering such as washing, dry cleaning, etc.
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'pricing_tier',
        'duration_minutes',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_minutes' => 'integer',
        'is_available' => 'boolean',
    ];

    // Pricing tiers
    public const PRICING_REGULAR = 'regular';
    public const PRICING_EXPRESS = 'express';
    public const PRICING_PREMIUM = 'premium';

    /**
     * Get the pricing tier label.
     */
    public function getPricingTierLabelAttribute(): string
    {
        return match($this->pricing_tier) {
            self::PRICING_EXPRESS => 'Express',
            self::PRICING_PREMIUM => 'Premium',
            default => 'Regular',
        };
    }

    /**
     * Get the category that owns the service.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * A service may belong to many orders via the pivot table order_service.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
