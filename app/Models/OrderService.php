<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Pivot model representing the relationship between orders and services. Not
 * strictly required but provides a place to centralize any custom logic on
 * the pivot.
 */
class OrderService extends Pivot
{
    protected $table = 'order_service';

    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
    ];
}