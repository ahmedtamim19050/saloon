<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salon_id',
        'provider_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'completed_at',
        'payment_status',
        'paid_at',
        'review_requested',
        'review_submitted',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'completed_at' => 'datetime',
        'paid_at' => 'datetime',
        'review_requested' => 'boolean',
        'review_submitted' => 'boolean',
    ];

    /**
     * Get the user that owns the appointment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the salon for the appointment
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get the provider for the appointment
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the service for the appointment
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the payment for the appointment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the review for the appointment
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the wallet entry for the appointment
     */
    public function walletEntry()
    {
        return $this->hasOne(ProviderWalletEntry::class);
    }

    /**
     * Check if appointment can be paid
     */
    public function canBePaid(): bool
    {
        return $this->status === 'completed' && $this->payment_status !== 'paid';
    }

    /**
     * Check if appointment can be reviewed
     */
    public function canBeReviewed(): bool
    {
        return $this->status === 'completed' && $this->payment_status === 'paid' && !$this->review_submitted;
    }
}
