<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventPayment extends Model
{
    protected $fillable = [
        'event_registration_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'payment_date',
        'invoice_number',
        'notes',
        'received_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    /**
     * Get the registration that the payment belongs to.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }

    /**
     * Get the user who received the payment.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Generate a unique invoice number.
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        $lastPayment = self::latest()->first();
        $lastId = $lastPayment ? $lastPayment->id + 1 : 1;

        return $prefix . '-' . $year . $month . $day . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Mark the payment as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed'
        ]);

        // Also update the registration
        $this->registration->markPaymentCompleted();
    }

    /**
     * Get the formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2) . ' MAD';
    }
}
