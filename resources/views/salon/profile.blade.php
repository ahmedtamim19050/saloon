@extends('layouts.salon-dashboard')

@section('title', 'Salon Profile')
@section('user-role', 'Salon Owner')
@section('header', 'Salon Profile')



@section('content')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

<style>
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .profile-card-header {
        padding: 24px 32px;
        border-bottom: 1px solid #e5e7eb;
    }

    .profile-card-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
    }

    .profile-card-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin: 4px 0 0 0;
    }

    .profile-card-body {
        padding: 32px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 8px;
    }

    .form-label-required::after {
        content: ' *';
        color: var(--primary-2);
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        color: var(--primary-dark);
        transition: all 0.3s ease;
    }

    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }

    .form-input.error, .form-textarea.error {
        border-color: #ef4444;
    }

    .form-error {
        font-size: 12px;
        color: #ef4444;
        margin-top: 6px;
        display: block;
    }

    .form-hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
        display: block;
    }

    /* File Upload Styles */
    .file-upload-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .file-upload-preview {
        width: 100%;
        height: 180px;
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f9fafb;
        position: relative;
        transition: all 0.3s ease;
    }

    .file-upload-preview:hover {
        border-color: var(--primary-2);
        background: rgba(190, 49, 68, 0.02);
    }

    .file-upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-upload-placeholder {
        text-align: center;
        color: #6b7280;
    }

    .file-upload-placeholder i {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 12px;
    }

    .file-upload-placeholder p {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }

    .file-upload-placeholder span {
        font-size: 12px;
        color: #9ca3af;
    }

    .file-upload-input {
        display: none;
    }

    .file-upload-btn {
        padding: 10px 20px;
        background: white;
        border: 2px solid var(--primary-2);
        color: var(--primary-2);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .file-upload-btn:hover {
        background: var(--primary-2);
        color: white;
    }

    .file-remove-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .file-upload-preview.has-image .file-remove-btn {
        display: flex;
    }

    .file-remove-btn:hover {
        background: rgba(239, 68, 68, 1);
        transform: scale(1.1);
    }

    /* Logo specific */
    .logo-upload-preview {
        width: 160px;
        height: 160px;
        border-radius: 50%;
    }

    .logo-upload-preview img {
        border-radius: 50%;
    }

    /* Rich Text Editor */
    .editor-wrapper {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .editor-wrapper:focus-within {
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }

    .ql-toolbar {
        background: #f9fafb;
        border: none !important;
        border-bottom: 1px solid #e5e7eb !important;
    }

    .ql-container {
        border: none !important;
        font-size: 14px;
        min-height: 200px;
    }

    /* Tags Input */
    .tagify {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }

    .tagify:hover {
        border-color: #d1d5db;
    }

    .tagify.tagify--focus {
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }

    .tagify__tag {
        background: linear-gradient(135deg, var(--primary-1), var(--primary-2));
        margin: 4px 4px 4px 0;
    }

    .tagify__tag > div {
        color: white;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-primary {
        padding: 14px 40px;
        background: linear-gradient(135deg, var(--primary-1), var(--primary-2));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(190, 49, 68, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(190, 49, 68, 0.4);
    }

    .btn-secondary {
        padding: 14px 32px;
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #d1d5db;
        background: #f9fafb;
    }

    /* Info Banner */
    .info-banner {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius: 16px;
        padding: 24px 32px;
        color: white;
        display: flex;
        gap: 20px;
        align-items: start;
    }

    .info-banner-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .info-banner-content h4 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .info-banner-content p {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
        margin: 0;
    }

    /* Subdomain Input Styles */
    .subdomain-input-wrapper {
        position: relative;
    }

    .subdomain-input-group {
        display: flex;
        align-items: center;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .subdomain-input-group:focus-within {
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }

    .subdomain-input-group.valid {
        border-color: #10b981;
    }

    .subdomain-input-group.invalid {
        border-color: #ef4444;
    }

    .subdomain-input {
        flex: 1;
        border: none !important;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 600;
        color: var(--primary-dark);
        box-shadow: none !important;
    }

    .subdomain-input:focus {
        outline: none;
    }

    .subdomain-suffix {
        padding: 12px 16px;
        background: #f3f4f6;
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        border-left: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .slug-feedback {
        margin-top: 8px;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        min-height: 20px;
    }

    .slug-feedback.checking {
        color: #3b82f6;
    }

    .slug-feedback.available {
        color: #10b981;
    }

    .slug-feedback.unavailable {
        color: #ef4444;
    }

    .slug-feedback i {
        font-size: 14px;
    }

    .slug-suggestions {
        margin-top: 12px;
        display: none;
    }

    .slug-suggestions.show {
        display: block;
    }

    .slug-suggestions-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .slug-suggestions-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .slug-suggestion-item {
        padding: 6px 12px;
        background: #f3f4f6;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--primary-dark);
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .slug-suggestion-item:hover {
        background: var(--primary-2);
        color: white;
        border-color: var(--primary-2);
        transform: translateY(-2px);
    }

    .slug-suggestion-item i {
        font-size: 10px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .profile-card-header {
            padding: 20px;
        }

        .profile-card-body {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .subdomain-input-group {
            flex-direction: column;
            align-items: stretch;
        }

        .subdomain-suffix {
            border-left: none;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
    }
</style>

<form action="{{ route('salon.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Basic Information -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">
                <i class="bi bi-info-circle me-2"></i>
                Basic Information
            </h3>
            <p class="profile-card-subtitle">Essential details about your salon</p>
        </div>
        <div class="profile-card-body">
            <!-- Salon Name -->
            <div class="form-group">
                <label for="name" class="form-label form-label-required">Salon Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $salon->name) }}" 
                    required
                    class="form-input @error('name') error @enderror"
                    placeholder="Enter your salon name">
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Subdomain/Slug -->
            <div class="form-group">
                <label for="slug" class="form-label form-label-required">
                    Salon Subdomain
                    <i class="bi bi-info-circle" data-bs-toggle="tooltip" title="Your unique salon URL"></i>
                </label>
                <div class="subdomain-input-wrapper">
                    <div class="subdomain-input-group">
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            value="{{ old('slug', $salon->slug ?? '') }}" 
                            required
                            class="form-input subdomain-input @error('slug') error @enderror"
                            placeholder="your-salon-name"
                            pattern="[a-z0-9-]+"
                            maxlength="50">
                        <span class="subdomain-suffix">.salon.test</span>
                    </div>
                    <div id="slugFeedback" class="slug-feedback"></div>
                    <div id="slugSuggestions" class="slug-suggestions"></div>
                </div>
                @error('slug')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">
                    <i class="bi bi-lightbulb"></i>
                    Your unique URL: <strong id="slugPreview">{{ old('slug', $salon->slug ?? 'your-slug') }}.salon.test</strong>
                </span>
            </div>

            <!-- Email & Phone -->
            <div class="form-row">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $salon->email) }}"
                        class="form-input @error('email') error @enderror"
                        placeholder="salon@example.com">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label form-label-required">Phone Number</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone', $salon->phone) }}" 
                        required
                        class="form-input @error('phone') error @enderror"
                        placeholder="+880 1XXX-XXXXXX">
                    @error('phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Short Description -->
            <div class="form-group">
                <label for="description" class="form-label">Short Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="form-textarea @error('description') error @enderror"
                    placeholder="A brief one-liner about your salon...">{{ old('description', $salon->description) }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">This appears in listings and search results (max 160 characters)</span>
            </div>
        </div>
    </div>

    <!-- Images -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">
                <i class="bi bi-image me-2"></i>
                Branding & Images
            </h3>
            <p class="profile-card-subtitle">Upload your salon logo and cover image</p>
        </div>
        <div class="profile-card-body">
            <div class="form-row">
                <!-- Logo -->
                <div class="form-group">
                    <label class="form-label">Salon Logo</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-preview logo-upload-preview {{ $salon->logo ? 'has-image' : '' }}" id="logoPreview">
                            @if($salon->logo)
                                <img src="{{ asset('storage/' . $salon->logo) }}" alt="Logo" id="logoImage">
                                <button type="button" class="file-remove-btn" onclick="removeImage('logo')">
                                    <i class="bi bi-x"></i>
                                </button>
                            @else
                                <div class="file-upload-placeholder">
                                    <i class="bi bi-shop"></i>
                                    <p>No logo uploaded</p>
                                    <span>Square image recommended</span>
                                </div>
                            @endif
                        </div>
                        <label for="logo" class="file-upload-btn">
                            <i class="bi bi-upload"></i>
                            Choose Logo
                        </label>
                        <input type="file" id="logo" name="logo" accept="image/*" class="file-upload-input" onchange="previewImage(this, 'logoPreview', 'logoImage')">
                    </div>
                    @error('logo')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">PNG, JPG or WEBP (Max 2MB)</span>
                </div>

                <!-- Cover Image -->
                <div class="form-group">
                    <label class="form-label">Cover Image</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-preview {{ $salon->cover_image ? 'has-image' : '' }}" id="coverPreview">
                            @if($salon->cover_image)
                                <img src="{{ asset('storage/' . $salon->cover_image) }}" alt="Cover" id="coverImage">
                                <button type="button" class="file-remove-btn" onclick="removeImage('cover')">
                                    <i class="bi bi-x"></i>
                                </button>
                            @else
                                <div class="file-upload-placeholder">
                                    <i class="bi bi-image"></i>
                                    <p>No cover image uploaded</p>
                                    <span>Wide image recommended (1920x400px)</span>
                                </div>
                            @endif
                        </div>
                        <label for="cover_image" class="file-upload-btn">
                            <i class="bi bi-upload"></i>
                            Choose Cover Image
                        </label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" class="file-upload-input" onchange="previewImage(this, 'coverPreview', 'coverImage')">
                    </div>
                    @error('cover_image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">PNG, JPG or WEBP (Max 5MB)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Location -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">
                <i class="bi bi-geo-alt me-2"></i>
                Location Details
            </h3>
            <p class="profile-card-subtitle">Where customers can find you</p>
        </div>
        <div class="profile-card-body">
            <!-- Address -->
            <div class="form-group">
                <label for="address" class="form-label form-label-required">Street Address</label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="2" 
                    required
                    class="form-textarea @error('address') error @enderror"
                    placeholder="House/Building, Street, Area">{{ old('address', $salon->address) }}</textarea>
                @error('address')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- City, State, Zip -->
            <div class="form-row">
                <div class="form-group">
                    <label for="city" class="form-label">City</label>
                    <input 
                        type="text" 
                        id="city" 
                        name="city" 
                        value="{{ old('city', $salon->city) }}"
                        class="form-input @error('city') error @enderror"
                        placeholder="e.g., Dhaka">
                    @error('city')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="state" class="form-label">State/Division</label>
                    <input 
                        type="text" 
                        id="state" 
                        name="state" 
                        value="{{ old('state', $salon->state) }}"
                        class="form-input @error('state') error @enderror"
                        placeholder="e.g., Dhaka Division">
                    @error('state')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="zip_code" class="form-label">Postal/Zip Code</label>
                <input 
                    type="text" 
                    id="zip_code" 
                    name="zip_code" 
                    value="{{ old('zip_code', $salon->zip_code) }}"
                    class="form-input @error('zip_code') error @enderror"
                    placeholder="e.g., 1200">
                @error('zip_code')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Full Description (Rich Text Editor) -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">
                <i class="bi bi-file-text me-2"></i>
                Detailed Description
            </h3>
            <p class="profile-card-subtitle">Tell customers more about your salon, services, and specialties</p>
        </div>
        <div class="profile-card-body">
            <div class="form-group">
                <label class="form-label">Full Description</label>
                <div class="editor-wrapper">
                    <div id="editor"></div>
                </div>
                <input type="hidden" name="full_description" id="full_description">
                @error('full_description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">Rich text editor - add formatting, lists, and more</span>
            </div>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">
                <i class="bi bi-search me-2"></i>
                SEO & Search Optimization
            </h3>
            <p class="profile-card-subtitle">Improve your salon's visibility in search engines</p>
        </div>
        <div class="profile-card-body">
            <!-- SEO Title -->
            <div class="form-group">
                <label for="seo_title" class="form-label">SEO Title</label>
                <input 
                    type="text" 
                    id="seo_title" 
                    name="seo_title" 
                    value="{{ old('seo_title', $salon->seo_title) }}"
                    class="form-input @error('seo_title') error @enderror"
                    placeholder="e.g., Best Hair Salon in Dhaka - Professional Beauty Services"
                    maxlength="60">
                @error('seo_title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">Appears in search results (50-60 characters optimal)</span>
            </div>

            <!-- SEO Description -->
            <div class="form-group">
                <label for="seo_description" class="form-label">SEO Meta Description</label>
                <textarea 
                    id="seo_description" 
                    name="seo_description" 
                    rows="3"
                    class="form-textarea @error('seo_description') error @enderror"
                    placeholder="Brief description for search engines..."
                    maxlength="160">{{ old('seo_description', $salon->seo_description) }}</textarea>
                @error('seo_description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">Search result snippet (150-160 characters optimal)</span>
            </div>

            <!-- Keywords -->
            <div class="form-group">
                <label for="keywords" class="form-label">Keywords</label>
                <input 
                    type="text" 
                    id="keywords" 
                    name="keywords" 
                    value="{{ old('keywords', is_array($salon->keywords) ? implode(', ', $salon->keywords) : '') }}"
                    class="form-input"
                    placeholder="Add keywords...">
                @error('keywords')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">Press Enter or comma to add keywords (e.g., hair salon, beauty parlor, spa)</span>
            </div>

            <!-- Tags -->
            <div class="form-group">
                <label for="tags" class="form-label">Tags</label>
                <input 
                    type="text" 
                    id="tags" 
                    name="tags" 
                    value="{{ old('tags', is_array($salon->tags) ? implode(', ', $salon->tags) : '') }}"
                    class="form-input"
                    placeholder="Add tags...">
                @error('tags')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint">Categorize your salon (e.g., luxury, affordable, bridal, men's grooming)</span>
            </div>
        </div>
    </div>

    <!-- Submit Actions -->
    <div class="profile-card">
        <div class="profile-card-body">
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('salon.dashboard') }}'">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Save All Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Help Banner -->
    <div class="info-banner">
        <div class="info-banner-icon">
            <i class="bi bi-lightbulb"></i>
        </div>
        <div class="info-banner-content">
            <h4>Pro Tips for Your Profile</h4>
            <p>
                • Use high-quality images for logo and cover to make a great first impression<br>
                • Write a detailed description highlighting your unique services and expertise<br>
                • Add relevant keywords and tags to improve search visibility<br>
                • Keep your contact information up-to-date so customers can reach you easily
            </p>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
    // Rich Text Editor (Quill)
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write a detailed description of your salon...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    // Set initial content
    const fullDescription = {!! json_encode(old('full_description', $salon->full_description ?? '')) !!};
    if (fullDescription) {
        quill.root.innerHTML = fullDescription;
    }

    // Update hidden input on form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        document.getElementById('full_description').value = quill.root.innerHTML;
    });

    // Tagify for Keywords
    const keywordsInput = document.getElementById('keywords');
    new Tagify(keywordsInput, {
        placeholder: 'Add keywords...',
        delimiters: ',',
        maxTags: 20
    });

    // Tagify for Tags
    const tagsInput = document.getElementById('tags');
    new Tagify(tagsInput, {
        placeholder: 'Add tags...',
        delimiters: ',',
        maxTags: 15
    });

    // Image Preview Function
    function previewImage(input, previewId, imageId) {
        const preview = document.getElementById(previewId);
        const placeholder = preview.querySelector('.file-upload-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (placeholder) {
                    placeholder.remove();
                }
                
                let img = document.getElementById(imageId);
                if (!img) {
                    img = document.createElement('img');
                    img.id = imageId;
                    preview.appendChild(img);
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'file-remove-btn';
                    removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                    removeBtn.onclick = function() {
                        const type = previewId.includes('logo') ? 'logo' : 'cover';
                        removeImage(type);
                    };
                    preview.appendChild(removeBtn);
                }
                
                img.src = e.target.result;
                preview.classList.add('has-image');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove Image Function
    function removeImage(type) {
        const input = document.getElementById(type === 'logo' ? 'logo' : 'cover_image');
        const preview = document.getElementById(type === 'logo' ? 'logoPreview' : 'coverPreview');
        const img = document.getElementById(type === 'logo' ? 'logoImage' : 'coverImage');
        
        input.value = '';
        preview.classList.remove('has-image');
        
        if (img) {
            img.remove();
        }
        
        const removeBtn = preview.querySelector('.file-remove-btn');
        if (removeBtn) {
            removeBtn.remove();
        }
        
        const placeholder = document.createElement('div');
        placeholder.className = 'file-upload-placeholder';
        placeholder.innerHTML = type === 'logo' 
            ? '<i class="bi bi-shop"></i><p>No logo uploaded</p><span>Square image recommended</span>'
            : '<i class="bi bi-image"></i><p>No cover image uploaded</p><span>Wide image recommended (1920x400px)</span>';
        
        preview.appendChild(placeholder);
    }

    // ==========================================
    // SUBDOMAIN/SLUG VALIDATION & SUGGESTIONS
    // ==========================================
    
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const slugPreview = document.getElementById('slugPreview');
    const slugFeedback = document.getElementById('slugFeedback');
    const slugSuggestions = document.getElementById('slugSuggestions');
    const slugInputGroup = document.querySelector('.subdomain-input-group');
    
    let checkTimeout = null;
    let originalSlug = '{{ old("slug", $salon->slug ?? "") }}';
    
    // Generate slug from text
    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-')          // Replace spaces with hyphens
            .replace(/-+/g, '-')           // Replace multiple hyphens with single
            .replace(/^-|-$/g, '');        // Remove leading/trailing hyphens
    }
    
    // Generate multiple slug suggestions
    function generateSuggestions(baseName) {
        const base = generateSlug(baseName);
        if (!base) return [];
        
        const suggestions = [
            base,
            base + '-salon',
            base + '-beauty',
            base + '-spa',
        ];
        
        // Add variations with numbers if original slug exists
        if (originalSlug && originalSlug !== base) {
            for (let i = 1; i <= 3; i++) {
                suggestions.push(base + '-' + i);
            }
        }
        
        return [...new Set(suggestions)].slice(0, 5);
    }
    
    // Show suggestions
    function showSuggestions(suggestions) {
        if (suggestions.length === 0) {
            slugSuggestions.classList.remove('show');
            return;
        }
        
        const html = `
            <span class="slug-suggestions-label">
                <i class="bi bi-lightbulb"></i> Suggestions:
            </span>
            <div class="slug-suggestions-list">
                ${suggestions.map(slug => `
                    <span class="slug-suggestion-item" onclick="selectSuggestion('${slug}')">
                        ${slug}
                        <i class="bi bi-arrow-right"></i>
                    </span>
                `).join('')}
            </div>
        `;
        
        slugSuggestions.innerHTML = html;
        slugSuggestions.classList.add('show');
    }
    
    // Select a suggestion
    window.selectSuggestion = function(slug) {
        slugInput.value = slug;
        updatePreview();
        checkSlugAvailability(slug);
        slugSuggestions.classList.remove('show');
    };
    
    // Update preview
    function updatePreview() {
        const slug = slugInput.value || 'your-slug';
        slugPreview.textContent = slug + '.salon.test';
    }
    
    // Check slug availability via AJAX
    function checkSlugAvailability(slug) {
        // Clear previous timeout
        clearTimeout(checkTimeout);
        
        // Reset states
        slugInputGroup.classList.remove('valid', 'invalid');
        
        // Don't check if empty
        if (!slug || slug.length < 3) {
            slugFeedback.innerHTML = '';
            return;
        }
        
        // If slug hasn't changed from original, mark as valid
        if (slug === originalSlug) {
            slugFeedback.innerHTML = '<i class="bi bi-check-circle-fill"></i> Current subdomain';
            slugFeedback.className = 'slug-feedback available';
            slugInputGroup.classList.add('valid');
            return;
        }
        
        // Show checking state
        slugFeedback.innerHTML = '<i class="bi bi-hourglass-split"></i> Checking availability...';
        slugFeedback.className = 'slug-feedback checking';
        
        // Debounce: wait 500ms after user stops typing
        checkTimeout = setTimeout(() => {
            fetch('/api/check-slug', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    slug: slug,
                    salon_id: {{ $salon->id ?? 'null' }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    slugFeedback.innerHTML = '<i class="bi bi-check-circle-fill"></i> Available! This subdomain is yours.';
                    slugFeedback.className = 'slug-feedback available';
                    slugInputGroup.classList.add('valid');
                    slugSuggestions.classList.remove('show');
                } else {
                    slugFeedback.innerHTML = '<i class="bi bi-x-circle-fill"></i> Already taken. Try another one.';
                    slugFeedback.className = 'slug-feedback unavailable';
                    slugInputGroup.classList.add('invalid');
                    
                    // Show suggestions if not available
                    const suggestions = generateSuggestions(nameInput.value);
                    showSuggestions(suggestions);
                }
            })
            .catch(error => {
                console.error('Slug check failed:', error);
                slugFeedback.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Check failed. Try again.';
                slugFeedback.className = 'slug-feedback unavailable';
            });
        }, 500);
    }
    
    // Auto-generate slug from salon name
    nameInput.addEventListener('input', function() {
        // Only auto-generate if slug is empty or matches previous name
        if (!slugInput.value || slugInput.value === generateSlug(this.dataset.previousValue || '')) {
            const generatedSlug = generateSlug(this.value);
            slugInput.value = generatedSlug;
            updatePreview();
            
            if (generatedSlug) {
                checkSlugAvailability(generatedSlug);
            }
        }
        
        this.dataset.previousValue = this.value;
    });
    
    // Validate and check slug on input
    slugInput.addEventListener('input', function() {
        // Force lowercase and remove invalid characters
        this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
        
        updatePreview();
        checkSlugAvailability(this.value);
    });
    
    // Initial check on page load
    if (slugInput.value) {
        updatePreview();
        checkSlugAvailability(slugInput.value);
    }
    
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush
