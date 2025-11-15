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
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    /**
     * Get the user that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the salon for the appointment.
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get the provider for the appointment.
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the service for the appointment.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the payment for the appointment.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the review for the appointment.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
