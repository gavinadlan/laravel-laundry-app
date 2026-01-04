<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Payment records a transaction for an order.
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_date',
        'method',
        'reference',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Payment methods
    public const METHOD_CASH = 'cash';
    public const METHOD_TRANSFER = 'transfer';
    public const METHOD_E_WALLET = 'e_wallet';
    public const METHOD_CREDIT_CARD = 'credit_card';
    public const METHOD_DEBIT_CARD = 'debit_card';

    /**
     * Get payment method label.
     */
    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            self::METHOD_CASH => 'Cash',
            self::METHOD_TRANSFER => 'Transfer',
            self::METHOD_E_WALLET => 'E-Wallet',
            self::METHOD_CREDIT_CARD => 'Credit Card',
            self::METHOD_DEBIT_CARD => 'Debit Card',
            default => ucfirst($this->method ?? 'Unknown'),
        };
    }

    /**
     * Get all payment methods.
     */
    public static function getMethods(): array
    {
        return [
            self::METHOD_CASH => 'Cash',
            self::METHOD_TRANSFER => 'Transfer',
            self::METHOD_E_WALLET => 'E-Wallet',
            self::METHOD_CREDIT_CARD => 'Credit Card',
            self::METHOD_DEBIT_CARD => 'Debit Card',
        ];
    }

    /**
     * The order this payment belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}