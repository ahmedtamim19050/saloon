<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'opening_time',
        'closing_time',
        'working_days',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'working_days' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the providers for the salon.
     */
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    /**
     * Get the appointments for the salon.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
