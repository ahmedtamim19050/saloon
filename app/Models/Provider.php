<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'name',
        'email',
        'phone',
        'photo',
        'expertise',
        'bio',
        'average_rating',
        'total_reviews',
        'is_active',
        'break_start',
        'break_end',
    ];

    protected $casts = [
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the salon that owns the provider.
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * The services that the provider offers.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'provider_service');
    }

    /**
     * Get the appointments for the provider.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the reviews for the provider.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
