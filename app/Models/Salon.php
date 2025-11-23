<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'website',
        'opening_time',
        'closing_time',
        'default_open_time',
        'default_close_time',
        'working_days',
        'off_days',
        'description',
        'full_description',
        'image',
        'cover_image',
        'logo',
        'is_active',
        'commission_percentage',
        'followers_count',
    ];

    protected $casts = [
        'working_days' => 'array',
        'off_days' => 'array',
        'is_active' => 'boolean',
        'commission_percentage' => 'decimal:2',
    ];

    /**
     * Get the owner of the salon
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the providers for the salon
     */
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    /**
     * Get the appointments for the salon
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the exceptions for the salon
     */
    public function exceptions()
    {
        return $this->hasMany(SalonException::class);
    }

    /**
     * Get users associated with this salon
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all reviews for the salon through providers
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Provider::class);
    }
}
