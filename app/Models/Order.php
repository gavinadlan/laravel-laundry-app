<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Order records a laundry order placed by a customer. Orders may include multiple services.
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'order_date',
        'delivery_date',
        'status',
        'notes',
    ];

    /**
     * Possible statuses for an order.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DELIVERED = 'delivered';

    /**
     * The customer who placed the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The services included in the order.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withPivot('quantity');
    }

    /**
     * The payments associated with the order (supports multiple payments).
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * The first payment associated with the order (for backward compatibility).
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class)->oldest();
    }

    /**
     * Generate invoice number automatically.
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        
        // Get the last invoice number for this month
        $lastOrder = self::where('invoice_number', 'like', "{$prefix}-{$year}{$month}-%")
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastOrder && $lastOrder->invoice_number) {
            $lastNumber = (int) substr($lastOrder->invoice_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $newNumber);
    }

    /**
     * Get total paid amount.
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    /**
     * Get outstanding amount (total - paid).
     */
    public function getOutstandingAttribute(): float
    {
        return max(0, $this->total - $this->total_paid);
    }

    /**
     * Get payment status.
     */
    public function getPaymentStatusAttribute(): string
    {
        $total = $this->total;
        $paid = $this->total_paid;
        
        if ($paid == 0) {
            return 'unpaid';
        } elseif ($paid >= $total) {
            return 'paid';
        } else {
            return 'partial';
        }
    }

    /**
     * Compute the total price of the order.
     * Sums price * quantity for each service.
     */
    public function getTotalAttribute(): float
    {
        return $this->services->sum(function ($service) {
            return $service->price * $service->pivot->quantity;
        });
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->invoice_number)) {
                $order->invoice_number = self::generateInvoiceNumber();
            }
        });
    }
}