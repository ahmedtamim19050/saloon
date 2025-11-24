@extends('layouts.salon-dashboard')

@section('title', 'Create Provider')
@section('header', 'Add New Provider')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
        max-width: 900px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 2px solid #f3f4f6;
    }

    .form-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #872341;
        box-shadow: 0 0 0 3px rgba(135, 35, 65, 0.1);
    }

    .photo-upload-area {
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .photo-upload-area:hover {
        border-color: #872341;
        background: #fef2f2;
    }

    .photo-upload-area.dragover {
        border-color: #872341;
        background: #fef2f2;
    }

    .photo-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 16px;
        display: none;
        border: 4px solid #872341;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, #872341, #BE3144);
        border: none;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(135, 35, 65, 0.4);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
        border: none;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .alert-banner {
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-banner i {
        font-size: 24px;
    }

    .commission-display {
        background: #fef3c7;
        border: 2px solid #fbbf24;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        margin-top: 12px;
    }

    .commission-value {
        font-size: 32px;
        font-weight: 700;
        color: #92400e;
    }

    .invalid-feedback {
        font-size: 12px;
        color: #dc2626;
        margin-top: 6px;
    }
</style>

<div class="alert-banner">
    <i class="bi bi-info-circle-fill"></i>
    <div>
        <strong>Creating a New Provider</strong>
        <p class="mb-0" style="font-size: 13px; opacity: 0.9;">This will create both a user account and provider profile. The provider will receive login credentials to access their dashboard.</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('salon.providers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Basic Information -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-person-fill"></i>
                Basic Information
            </h3>
            
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required placeholder="Enter provider's full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required placeholder="provider@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">This will be used for login</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone') }}" required placeholder="+880 1234-567890">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Account Security -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-shield-lock-fill"></i>
                Account Security
            </h3>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           required placeholder="Minimum 8 characters">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" 
                           required placeholder="Re-enter password">
                </div>
            </div>
        </div>

        <!-- Commission Settings -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-percent"></i>
                Commission Settings
            </h3>
            
            <div class="row">
                <div class="col-md-8">
                    <label class="form-label">Commission Percentage <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="commission_percentage" id="commissionInput"
                               class="form-control @error('commission_percentage') is-invalid @enderror" 
                               value="{{ old('commission_percentage', 30) }}" 
                               min="0" max="100" step="0.01" required>
                        <span class="input-group-text" style="background: #872341; color: white; border: none;">
                            <i class="bi bi-percent"></i>
                        </span>
                    </div>
                    @error('commission_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Provider's commission from each appointment</small>
                </div>
                <div class="col-md-4">
                    <div class="commission-display">
                        <small style="color: #92400e; font-weight: 600;">Commission</small>
                        <div class="commission-value" id="commissionDisplay">30%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Details -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-briefcase-fill"></i>
                Professional Details
            </h3>
            
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Expertise / Specialization</label>
                    <input type="text" name="expertise" class="form-control @error('expertise') is-invalid @enderror" 
                           value="{{ old('expertise') }}" placeholder="e.g., Hair Styling, Makeup, Spa Treatment">
                    @error('expertise')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Bio / Description</label>
                    <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" 
                              placeholder="Brief description about the provider's experience and skills">{{ old('bio') }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Profile Photo -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-camera-fill"></i>
                Profile Photo
            </h3>
            
            <div class="photo-upload-area" onclick="document.getElementById('photoInput').click()">
                <img id="photoPreview" class="photo-preview" alt="Photo Preview">
                <i class="bi bi-cloud-upload" style="font-size: 48px; color: #872341; margin-bottom: 16px;"></i>
                <p style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">
                    <strong>Click to upload</strong> or drag and drop
                </p>
                <p style="font-size: 12px; color: #9ca3af; margin: 0;">
                    PNG, JPG, WEBP up to 2MB
                </p>
            </div>
            <input type="file" id="photoInput" name="photo" class="d-none" accept="image/*">
            @error('photo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-toggle-on"></i>
                Account Status
            </h3>
            
            <div class="form-check form-switch" style="padding-left: 2.5rem;">
                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" 
                       value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                       style="width: 48px; height: 24px; cursor: pointer;">
                <label class="form-check-label" for="isActiveSwitch" style="margin-left: 12px; font-weight: 600;">
                    Activate provider account immediately
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 justify-content-end">
            <a href="{{ route('salon.providers') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Create Provider
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Commission percentage display
    const commissionInput = document.getElementById('commissionInput');
    const commissionDisplay = document.getElementById('commissionDisplay');

    commissionInput.addEventListener('input', function() {
        const value = parseFloat(this.value) || 0;
        commissionDisplay.textContent = value.toFixed(2) + '%';
    });

    // Photo upload preview
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const uploadArea = document.querySelector('.photo-upload-area');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            photoInput.files = e.dataTransfer.files;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
