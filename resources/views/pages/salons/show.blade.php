@extends('layouts.subdomain')

@section('title', $salon->name)

@push('styles')
<link href="{{ asset('css/home-sections.css') }}" rel="stylesheet">
<style>
    /* Facebook-style Cover Design */
    .salon-cover {
        position: relative;
        height: 450px;
        background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
        overflow: hidden;
    }
    
    .salon-cover-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.9;
    }
    
    .salon-profile-section {
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .salon-profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
    }
    
    .salon-profile-header {
        display: flex;
        align-items: flex-end;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
        margin-top: -80px;
        gap: 2rem;
    }
    
    .salon-logo-wrapper {
        position: relative;
        flex-shrink: 0;
    }
    
    .salon-logo {
        width: 180px;
        height: 180px;
        border-radius: 16px;
        border: 5px solid white;
        object-fit: cover;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .salon-logo-placeholder {
        width: 180px;
        height: 180px;
        border-radius: 16px;
        border: 5px solid white;
        background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .salon-info {
        flex: 1;
        padding-bottom: 1rem;
    }
    
    .salon-name {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }
    
    .salon-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        color: #6b7280;
        font-size: 0.9375rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .salon-actions {
        display: flex;
        gap: 1rem;
        padding-top: 1rem;
    }
    
    .btn-action {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }
    
    .btn-primary-action {
        background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }
    
    .btn-primary-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(135, 35, 65, 0.4);
        color: white;
    }
    
    .btn-secondary-action {
        background: #f3f4f6;
        color: #4b5563;
    }
    
    .btn-secondary-action:hover {
        background: #e5e7eb;
        color: #1f2937;
    }
    
    .salon-social {
        display: flex;
        gap: 0.75rem;
        margin-left: auto;
        align-items: center;
    }
    
    .salon-social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 1.125rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .salon-social-link:hover {
        background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
        color: white;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .salon-cover { height: 300px; }
        .salon-profile-header { flex-direction: column; align-items: center; text-align: center; margin-top: -60px; }
        .salon-logo, .salon-logo-placeholder { width: 140px; height: 140px; }
        .salon-name { font-size: 1.5rem; }
        .salon-social { margin-left: 0; margin-top: 1rem; }
    }
</style>
@endpush

@section('content')
<!-- Facebook-style Cover Section -->
<section class="salon-cover">
    @if($salon->cover_image)
        <img src="{{ asset('storage/' . $salon->cover_image) }}" alt="{{ $salon->name }}" class="salon-cover-image">
    @endif
</section>

<!-- Profile Section (Like Facebook Profile) -->
<section class="salon-profile-section">
    <div class="salon-profile-container">
        <div class="salon-profile-header">
            <!-- Logo -->
            <div class="salon-logo-wrapper">
                @if($salon->logo)
                    <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name }}" class="salon-logo">
                @else
                    <div class="salon-logo-placeholder">
                        {{ strtoupper(substr($salon->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            
            <!-- Salon Info -->
            <div class="salon-info">
                <h1 class="salon-name">{{ $salon->name }}</h1>
                <div class="salon-meta">
                    <span><i class="bi bi-geo-alt-fill"></i> {{ $salon->city }}, {{ $salon->state }}</span>
                    <span><i class="bi bi-star-fill" style="color: #F59E0B;"></i> 4.8 ({{ $salon->reviews()->count() }} reviews)</span>
                    <span><i class="bi bi-people-fill"></i> {{ $salon->providers->count() }} Professionals</span>
                </div>
                
                <div class="salon-actions">
                    <a href="{{ route('appointments.book') }}" class="btn-action btn-primary-action">
                        <i class="bi bi-calendar-check-fill"></i> Book Appointment
                    </a>
                    <a href="#contact" class="btn-action btn-secondary-action smooth-scroll">
                        <i class="bi bi-envelope-fill"></i> Contact
                    </a>
                </div>
            </div>
            
            <!-- Social Icons -->
            <div class="salon-social">
                @if($salon->facebook)
                    <a href="{{ $salon->facebook }}" target="_blank" class="salon-social-link" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                @endif
                @if($salon->instagram)
                    <a href="{{ $salon->instagram }}" target="_blank" class="salon-social-link" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                @endif
                @if($salon->twitter)
                    <a href="{{ $salon->twitter }}" target="_blank" class="salon-social-link" title="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                @endif
                @if($salon->linkedin)
                    <a href="{{ $salon->linkedin }}" target="_blank" class="salon-social-link" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                @endif
                @if($salon->youtube)
                    <a href="{{ $salon->youtube }}" target="_blank" class="salon-social-link" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section style="padding: 4rem 0;">
    <div class="container">
        <!-- About Section -->
        <div class="row mb-5" id="about">
            <div class="col-lg-8 animate-on-scroll">
                <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1.5rem;">
                        <i class="bi bi-building"></i> About Us
                    </h2>
                    <p style="font-size: 1.125rem; line-height: 1.8; color: #4a5568; margin-bottom: 2rem;">
                        {{ $salon->full_description ?? $salon->description ?? 'Welcome to our premium salon. We provide exceptional grooming services delivered by experienced professionals.' }}
                    </p>
                    
                    <!-- Stats -->
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #872341 0%, #BE3144 100%); border-radius: 16px; color: white;">
                                <div style="font-size: 2.5rem; font-weight: 700;">{{ $salon->providers->count() }}</div>
                                <div style="font-size: 0.875rem; opacity: 0.9;">Professionals</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #10B981 0%, #059669 100%); border-radius: 16px; color: white;">
                                <div style="font-size: 2.5rem; font-weight: 700;">{{ $salon->reviews()->count() }}</div>
                                <div style="font-size: 0.875rem; opacity: 0.9;">Reviews</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); border-radius: 16px; color: white;">
                                @php $serviceCount = $salon->providers->flatMap->services->unique('id')->count(); @endphp
                                <div style="font-size: 2.5rem; font-weight: 700;">{{ $serviceCount }}</div>
                                <div style="font-size: 0.875rem; opacity: 0.9;">Services</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); border-radius: 16px; color: white;">
                                <div style="font-size: 2.5rem; font-weight: 700;">4.8</div>
                                <div style="font-size: 0.875rem; opacity: 0.9;">Rating</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 animate-on-scroll">
                <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">
                        <i class="bi bi-clock-fill"></i> Working Hours
                    </h3>
                    @php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        $workingDays = array_map('strtolower', $salon->working_days ?? []);
                    @endphp
                    @foreach($days as $day)
                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="font-weight: 500; color: #1a1a1a;">{{ $day }}</span>
                            @if(in_array(strtolower($day), $workingDays))
                                <span style="color: #10B981; font-weight: 600; font-size: 0.875rem;">
                                    {{ \Carbon\Carbon::parse($salon->opening_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($salon->closing_time)->format('g:i A') }}
                                </span>
                            @else
                                <span style="color: #9ca3af;">Closed</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);" id="contact">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">
                        <i class="bi bi-telephone-fill"></i> Contact Info
                    </h3>
                    <div style="margin-bottom: 1rem;">
                        <a href="tel:{{ $salon->phone }}" style="color: #872341; text-decoration: none; font-size: 1.125rem;">
                            <i class="bi bi-telephone-fill me-2"></i>{{ $salon->phone }}
                        </a>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <a href="mailto:{{ $salon->email }}" style="color: #872341; text-decoration: none;">
                            <i class="bi bi-envelope-fill me-2"></i>{{ $salon->email }}
                        </a>
                    </div>
                    <div style="color: #4a5568; line-height: 1.6;">
                        <i class="bi bi-geo-alt-fill" style="color: #872341;"></i>
                        {{ $salon->address }}, {{ $salon->city }}, {{ $salon->state }} @if($salon->zip_code) {{ $salon->zip_code }} @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- Team Section (Dark - Full Width) -->
<section style="background: linear-gradient(135deg, rgba(9, 18, 44, 0.98) 0%, rgba(9, 18, 44, 0.95) 100%); padding: 5rem 0; position: relative; overflow: hidden;" id="team" class="animate-on-scroll">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>'); opacity: 0.5;"></div>
    <div class="container-fluid" style="position: relative; z-index: 1;">
        <div class="text-center mb-5">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 1rem;">
                <i class="bi bi-people-fill"></i> Our Professional Team
            </h2>
            <p style="color: rgba(255, 255, 255, 0.7); font-size: 1.125rem; max-width: 600px; margin: 0 auto;">Meet our talented professionals dedicated to making you look and feel your best</p>
        </div>
        <div class="row g-4 justify-content-center">
                        @foreach($salon->providers as $provider)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 1.5rem; text-align: center; transition: all 0.4s; backdrop-filter: blur(10px);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 32px rgba(135, 35, 65, 0.4)'; this.style.background='rgba(255, 255, 255, 0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='rgba(255, 255, 255, 0.08)';">
                                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 50%; background: linear-gradient(135deg, #872341 0%, #BE3144 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: 0 4px 16px rgba(190, 49, 68, 0.4);">
                                        @if($provider->photo)
                                            <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->user->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                        @else
                                            {{ strtoupper(substr($provider->user->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: white;">{{ $provider->user->name }}</h3>
                                    <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.875rem; margin-bottom: 0.75rem;">Professional Stylist</p>
                                    <div style="color: #F59E0B; margin-bottom: 1rem;">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span style="color: #4a5568; margin-left: 0.5rem;">4.8</span>
                                    </div>
                                    <a href="/providers/{{ $provider->id }}" class="btn btn-sm" style="background: linear-gradient(135deg, #872341 0%, #BE3144 100%); color: white; padding: 0.5rem 1.5rem; border-radius: 8px; text-decoration: none; display: inline-block;">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <!-- Services Section -->
        <div class="row mb-5" id="services">
            <div class="col-12 animate-on-scroll">
                <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 2rem;">
                        <i class="bi bi-scissors"></i> Our Services
                    </h2>
                    <div class="row g-4">
                        @php $uniqueServices = $salon->providers->flatMap->services->unique('id'); @endphp
                        @foreach($uniqueServices as $service)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div style="border: 1px solid #e5e7eb; border-radius: 16px; padding: 1.5rem; height: 100%;">
                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(135, 35, 65, 0.1), rgba(190, 49, 68, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #872341; font-size: 1.5rem; margin-bottom: 1rem;">
                                        <i class="bi bi-scissors"></i>
                                    </div>
                                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">{{ $service->name }}</h3>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: #872341; margin-bottom: 0.75rem;">${{ number_format($service->price, 2) }}</p>
                                    <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.6;">{{ $service->description ?? 'Professional service by expert stylists' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- Customer Says Section (Dark Slider - Full Width) -->
<section style="background: linear-gradient(135deg, rgba(9, 18, 44, 0.98) 0%, rgba(9, 18, 44, 0.95) 100%); padding: 5rem 0; position: relative; overflow: hidden;" id="reviews" class="animate-on-scroll">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>'); opacity: 0.5;"></div>
    <div class="container-fluid" style="position: relative; z-index: 1;">
        <div class="text-center mb-5">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 1rem;">
                <i class="bi bi-chat-quote-fill" style="color: #F59E0B;"></i> What Our Customers Say
            </h2>
            <p style="color: rgba(255, 255, 255, 0.7); font-size: 1.125rem;">Real experiences from our valued clients</p>
        </div>
                    
        @php $allReviews = $salon->reviews()->with('user')->latest()->get(); @endphp
        
        @if($allReviews->count() > 0)
            <!-- Reviews Slider -->
            <div style="position: relative; max-width: 1400px; margin: 0 auto;">
                <div id="reviewsSlider" class="reviews-slider" style="display: flex; overflow: hidden; scroll-behavior: smooth; gap: 2rem; padding: 1rem 0;">
                    @foreach($allReviews as $index => $review)
                        <div class="review-slide" style="flex: 0 0 auto; width: 350px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 2rem; backdrop-filter: blur(10px); transition: all 0.4s;">
                            <!-- Quote Icon -->
                            <div style="color: rgba(245, 158, 11, 0.3); font-size: 3rem; margin-bottom: 1rem; line-height: 1;">
                                <i class="bi bi-quote"></i>
                            </div>
                            
                            <!-- Review Text -->
                            <p style="color: rgba(255, 255, 255, 0.9); line-height: 1.8; margin-bottom: 1.5rem; font-size: 1rem; min-height: 120px;">{{ $review->comment }}</p>
                            
                            <!-- Rating -->
                            <div style="color: #F59E0B; margin-bottom: 1.5rem; font-size: 1.125rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star-fill" style="color: {{ $i <= $review->rating ? '#F59E0B' : 'rgba(255, 255, 255, 0.2)' }};"></i>
                                @endfor
                            </div>
                            
                            <!-- Author Info -->
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #872341 0%, #BE3144 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.25rem; box-shadow: 0 4px 16px rgba(190, 49, 68, 0.4);">
                                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: white; font-size: 1.0625rem;">{{ $review->user->name }}</div>
                                    <div style="color: rgba(255, 255, 255, 0.5); font-size: 0.875rem;">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Slider Controls -->
                <button onclick="slideReviews(-1)" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); color: white; font-size: 1.5rem; cursor: pointer; transition: all 0.3s; z-index: 10;" onmouseover="this.style.background='linear-gradient(135deg, #872341 0%, #BE3144 100%)'; this.style.transform='translateY(-50%) scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(-50%)';">‹</button>
                <button onclick="slideReviews(1)" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); color: white; font-size: 1.5rem; cursor: pointer; transition: all 0.3s; z-index: 10;" onmouseover="this.style.background='linear-gradient(135deg, #872341 0%, #BE3144 100%)'; this.style.transform='translateY(-50%) scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(-50%)';">›</button>
                
                <!-- Slider Dots -->
                <div class="text-center mt-4" id="sliderDots" style="display: flex; gap: 0.5rem; justify-content: center;"></div>
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: rgba(255, 255, 255, 0.05); border-radius: 20px; border: 1px dashed rgba(255, 255, 255, 0.2); max-width: 600px; margin: 0 auto;">
                <i class="bi bi-chat-quote" style="font-size: 5rem; color: rgba(255, 255, 255, 0.2); margin-bottom: 1.5rem;"></i>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem;">No Reviews Yet</h3>
                <p style="color: rgba(255, 255, 255, 0.5); font-size: 1.125rem;">Be the first to share your experience!</p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
let currentSlide = 0;
const slider = document.getElementById('reviewsSlider');
const slides = slider?.querySelectorAll('.review-slide');
const totalSlides = slides?.length || 0;

function updateSlider() {
    if (!slider || totalSlides === 0) return;
    
    const slideWidth = slides[0].offsetWidth + 32; // width + gap
    slider.scrollLeft = currentSlide * slideWidth;
    
    // Update dots
    updateDots();
}

function slideReviews(direction) {
    if (totalSlides === 0) return;
    
    currentSlide += direction;
    
    // Loop around
    if (currentSlide < 0) currentSlide = totalSlides - 1;
    if (currentSlide >= totalSlides) currentSlide = 0;
    
    updateSlider();
}

function createDots() {
    if (totalSlides === 0) return;
    
    const dotsContainer = document.getElementById('sliderDots');
    if (!dotsContainer) return;
    
    dotsContainer.innerHTML = '';
    
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('button');
        dot.style.cssText = 'width: 10px; height: 10px; border-radius: 50%; border: 1px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.2); cursor: pointer; transition: all 0.3s; padding: 0;';
        dot.onclick = () => {
            currentSlide = i;
            updateSlider();
        };
        dotsContainer.appendChild(dot);
    }
    
    updateDots();
}

function updateDots() {
    const dots = document.querySelectorAll('#sliderDots button');
    dots.forEach((dot, index) => {
        if (index === currentSlide) {
            dot.style.background = 'linear-gradient(135deg, #872341 0%, #BE3144 100%)';
            dot.style.width = '30px';
            dot.style.borderColor = 'transparent';
        } else {
            dot.style.background = 'rgba(255, 255, 255, 0.2)';
            dot.style.width = '10px';
            dot.style.borderColor = 'rgba(255, 255, 255, 0.3)';
        }
    });
}

// Auto-slide every 5 seconds
setInterval(() => {
    if (totalSlides > 0) {
        slideReviews(1);
    }
}, 5000);

// Initialize
if (totalSlides > 0) {
    createDots();
    updateSlider();
}
</script>
@endpush

@endsection
