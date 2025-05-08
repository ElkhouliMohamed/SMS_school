<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'student_id',
        'status',
        'payment_required',
        'payment_completed',
        'notes'
    ];

    protected $casts = [
        'payment_required' => 'boolean',
        'payment_completed' => 'boolean',
    ];

    /**
     * Get the event that the registration belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the student that the registration belongs to.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the payment for the registration.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(EventPayment::class);
    }

    /**
     * Check if the registration has a payment.
     */
    public function hasPayment(): bool
    {
        return $this->payment()->exists();
    }

    /**
     * Check if the registration requires payment.
     */
    public function requiresPayment(): bool
    {
        return $this->payment_required;
    }

    /**
     * Mark the registration as payment completed.
     */
    public function markPaymentCompleted(): void
    {
        $this->update([
            'payment_completed' => true,
            'status' => 'confirmed'
        ]);
    }
}
