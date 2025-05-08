<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'price',
        'is_free',
        'capacity',
        'image',
        'status',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
    ];

    /**
     * Get the user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the registrations for the event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the number of students registered for the event.
     */
    public function getRegisteredCountAttribute(): int
    {
        return $this->registrations()->count();
    }

    /**
     * Get the number of available spots for the event.
     */
    public function getAvailableSpotsAttribute(): int
    {
        if (!$this->capacity) {
            return PHP_INT_MAX; // Unlimited capacity
        }

        return max(0, $this->capacity - $this->registered_count);
    }

    /**
     * Check if the event is full.
     */
    public function getIsFullAttribute(): bool
    {
        if (!$this->capacity) {
            return false; // Unlimited capacity
        }

        return $this->registered_count >= $this->capacity;
    }

    /**
     * Check if the event requires payment.
     */
    public function getRequiresPaymentAttribute(): bool
    {
        return !$this->is_free && $this->price > 0;
    }
}
