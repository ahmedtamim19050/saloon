<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
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
        'status',
        'commission_percentage',
        'followers_count',
        'seo_title',
        'seo_description',
        'keywords',
        'tags',
    ];

    protected $casts = [
        'working_days' => 'array',
        'off_days' => 'array',
        'is_active' => 'boolean',
        'commission_percentage' => 'decimal:2',
        'keywords' => 'array',
        'tags' => 'array',
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

    /**
     * Get all unique services offered by salon's providers (many-to-many through providers)
     */
    public function services()
    {
        return $this->hasManyThrough(
            Service::class,
            Provider::class,
            'salon_id', // Foreign key on providers table
            'id', // Foreign key on services table
            'id', // Local key on salons table
            'id' // Local key on providers table
        )->join('provider_service', 'provider_service.service_id', '=', 'services.id')
         ->whereColumn('provider_service.provider_id', 'providers.id')
         ->select('services.*')
         ->distinct();
    }

    /**
     * Get route key name for route model binding
     * Only use slug for subdomain routes, not main domain
     */
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    /**
     * Get the subdomain URL for this salon
     */
    public function getSubdomainUrlAttribute()
    {
        if (!$this->slug) {
            return null;
        }
        
        $protocol = request()->secure() ? 'https' : 'http';
        return "{$protocol}://{$this->slug}.saloon.test";
    }

    /**
     * Check if salon has active subdomain
     */
    public function hasSubdomain()
    {
        return !empty($this->slug) && $this->status === 'active';
    }
}
