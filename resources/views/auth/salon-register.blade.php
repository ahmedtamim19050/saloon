@extends('layouts.app')

@section('title', 'Register as Salon Owner')

@push('styles')
<style>
    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-1) 50%, var(--primary-2) 100%);
        position: relative;
        overflow: hidden;
        padding: 2rem 1rem;
    }
    
    .auth-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        opacity: 0.5;
    }
    
    .auth-floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }
    
    .auth-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float-shapes 20s infinite ease-in-out;
    }
    
    .auth-shape:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        left: -100px;
        animation-delay: 0s;
    }
    
    .auth-shape:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        right: -50px;
        animation-delay: 5s;
    }
    
    .auth-shape:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 50%;
        right: 10%;
        animation-delay: 10s;
    }
    
    @keyframes float-shapes {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }
    
    .auth-card {
        position: relative;
        z-index: 10;
        background: var(--white);
        border-radius: var(--radius-2xl);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 560px;
        width: 100%;
        overflow: hidden;
        animation: slideInUp 0.8s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .auth-header {
        text-align: center;
        padding: 3rem 3rem 2rem;
        background: linear-gradient(180deg, rgba(190, 49, 68, 0.05) 0%, transparent 100%);
    }
    
    .auth-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--white);
        box-shadow: 0 8px 24px rgba(190, 49, 68, 0.3);
        animation: pulse-icon 2s ease-in-out infinite;
    }
    
    @keyframes pulse-icon {
        0%, 100% { transform: scale(1); box-shadow: 0 8px 24px rgba(190, 49, 68, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 12px 32px rgba(190, 49, 68, 0.4); }
    }
    
    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        font-family: var(--font-heading);
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
    }
    
    .auth-subtitle {
        color: var(--gray-600);
        font-size: 1rem;
    }
    
    .auth-subtitle a {
        color: var(--primary-2);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .auth-subtitle a:hover {
        color: var(--primary-1);
        text-decoration: underline;
    }
    
    .auth-body {
        padding: 2rem 3rem 3rem;
    }
    
    .info-banner {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
        border: 2px solid rgba(34, 197, 94, 0.3);
        border-radius: var(--radius-xl);
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: start;
        gap: 1rem;
    }

    .info-banner i {
        font-size: 1.5rem;
        color: var(--success);
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .info-banner-text {
        color: var(--success);
        font-size: 0.9375rem;
        font-weight: 500;
        line-height: 1.6;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }
    
    .form-label i {
        color: var(--primary-2);
    }
    
    .form-input-wrapper {
        position: relative;
    }
    
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-xl);
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }
    
    .form-input.error {
        border-color: var(--danger);
    }
    
    .form-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 1.125rem;
        transition: color 0.3s ease;
    }
    
    .form-input:focus ~ .form-icon {
        color: var(--primary-2);
    }
    
    .form-error {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .btn-auth {
        width: 100%;
        padding: 1rem 2rem;
        background: var(--gradient-primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-xl);
        font-size: 1.0625rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(190, 49, 68, 0.3);
        position: relative;
        overflow: hidden;
        margin-top: 1rem;
    }
    
    .btn-auth::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-auth:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(190, 49, 68, 0.4);
    }
    
    .btn-auth:active {
        transform: translateY(0);
    }

    .alternative-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
        color: var(--gray-600);
        font-size: 0.9375rem;
    }

    .alternative-link a {
        color: var(--primary-2);
        font-weight: 600;
        text-decoration: none;
    }

    .alternative-link a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 576px) {
        .auth-header {
            padding: 2rem 1.5rem 1.5rem;
        }
        
        .auth-body {
            padding: 1.5rem;
        }
        
        .auth-title {
            font-size: 1.75rem;
        }
        
        .auth-icon {
            width: 70px;
            height: 70px;
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-floating-shapes">
        <div class="auth-shape"></div>
        <div class="auth-shape"></div>
        <div class="auth-shape"></div>
    </div>
    
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="bi bi-shop"></i>
            </div>
            <h1 class="auth-title">Register Your Salon</h1>
            <p class="auth-subtitle">
                Already have an account? 
                <a href="{{ route('login') }}">Sign in instead</a>
            </p>
        </div>
        
        <div class="auth-body">
            <div class="info-banner">
                <i class="bi bi-info-circle-fill"></i>
                <div class="info-banner-text">
                    After registration, you'll be redirected to your profile to complete your salon details.
                </div>
            </div>

            <form method="POST" action="{{ route('salon.register.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="bi bi-person"></i>
                        Full Name
                    </label>
                    <div class="form-input-wrapper">
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name') }}" 
                            required 
                            autocomplete="name" 
                            autofocus
                            placeholder="Enter your full name"
                            class="form-input @error('name') error @enderror"
                        >
                        <i class="bi bi-person form-icon"></i>
                    </div>
                    @error('name')
                        <p class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope"></i>
                        Email Address
                    </label>
                    <div class="form-input-wrapper">
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                            placeholder="Enter your email"
                            class="form-input @error('email') error @enderror"
                        >
                        <i class="bi bi-envelope form-icon"></i>
                    </div>
                    @error('email')
                        <p class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="bi bi-telephone"></i>
                        Phone Number
                    </label>
                    <div class="form-input-wrapper">
                        <input 
                            id="phone" 
                            name="phone" 
                            type="tel" 
                            value="{{ old('phone') }}" 
                            required
                            placeholder="Enter your phone number"
                            class="form-input @error('phone') error @enderror"
                        >
                        <i class="bi bi-telephone form-icon"></i>
                    </div>
                    @error('phone')
                        <p class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="salon_name" class="form-label">
                        <i class="bi bi-shop"></i>
                        Salon Name
                    </label>
                    <div class="form-input-wrapper">
                        <input 
                            id="salon_name" 
                            name="salon_name" 
                            type="text" 
                            value="{{ old('salon_name') }}" 
                            required
                            placeholder="Enter your salon name"
                            class="form-input @error('salon_name') error @enderror"
                        >
                        <i class="bi bi-shop form-icon"></i>
                    </div>
                    @error('salon_name')
                        <p class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i>
                        Password
                    </label>
                    <div class="form-input-wrapper">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Create password"
                            class="form-input @error('password') error @enderror"
                        >
                        <i class="bi bi-lock form-icon"></i>
                    </div>
                    @error('password')
                        <p class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="bi bi-lock-fill"></i>
                        Confirm Password
                    </label>
                    <div class="form-input-wrapper">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm password"
                            class="form-input"
                        >
                        <i class="bi bi-lock-fill form-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-shop-window"></i>
                    Register Salon
                </button>

                <div class="alternative-link">
                    Want to register as a customer? 
                    <a href="{{ route('register') }}">Register here</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
