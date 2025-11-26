@extends('salon-subdomain.layout')

@section('title', 'Contact Us - ' . $currentSalon->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="mb-4 text-center">
                <h2><i class="bi bi-telephone-fill text-primary"></i> Contact Us</h2>
                <p class="text-muted">Get in touch with us</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-telephone-fill fs-1 text-primary mb-3"></i>
                            <h5>Phone</h5>
                            <p class="text-muted mb-0">{{ $currentSalon->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-envelope-fill fs-1 text-primary mb-3"></i>
                            <h5>Email</h5>
                            <p class="text-muted mb-0">{{ $currentSalon->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-geo-alt-fill fs-1 text-danger mb-3"></i>
                            <h5>Address</h5>
                            <p class="text-muted mb-0">{{ $currentSalon->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-clock-fill fs-1 text-warning mb-3"></i>
                            <h5>Working Hours</h5>
                            @if($currentSalon->default_open_time && $currentSalon->default_close_time)
                                <p class="text-muted mb-0">
                                    {{ \Carbon\Carbon::parse($currentSalon->default_open_time)->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($currentSalon->default_close_time)->format('g:i A') }}
                                </p>
                            @else
                                <p class="text-muted mb-0">Mon - Fri: 9:00 AM - 8:00 PM</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4">Send us a message</h4>
                    <form action="{{ route('salon.contact.submit', $currentSalon->slug) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Your Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" 
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-send"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
