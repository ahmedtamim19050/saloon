@extends('layouts.salon-dashboard')

@section('content')
<style>
    .settings-header {
        background: linear-gradient(135deg, #872341, #BE3144);
        padding: 32px;
        border-radius: 16px;
        margin-bottom: 32px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .settings-header-left h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .settings-header-left p {
        margin: 0;
        opacity: 0.9;
    }

    .btn-view-salon {
        padding: 12px 24px;
        background: white;
        color: #872341;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view-salon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,255,255,0.3);
        color: #872341;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    .settings-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .settings-card h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #09122C;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .settings-card p {
        font-size: 14px;
        color: #666;
        margin-bottom: 24px;
    }

    .form-group-settings {
        margin-bottom: 20px;
    }

    .form-group-settings label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #09122C;
        margin-bottom: 8px;
    }

    .form-group-settings label .required {
        color: #DC3545;
        margin-left: 2px;
    }

    .form-control-settings {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control-settings:focus {
        outline: none;
        border-color: #872341;
        box-shadow: 0 0 0 3px rgba(135, 35, 65, 0.1);
    }

    .form-control-settings.is-invalid {
        border-color: #DC3545;
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #DC3545;
        margin-top: 4px;
    }

    .form-help-text {
        display: block;
        font-size: 12px;
        color: #999;
        margin-top: 4px;
    }

    .input-with-icon {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 16px;
        pointer-events: none;
    }

    .commission-display-settings {
        background: #FFF9E6;
        border: 2px solid #FFD700;
        border-radius: 12px;
        padding: 16px;
        margin-top: 12px;
        text-align: center;
    }

    .commission-display-settings small {
        display: block;
        font-size: 12px;
        color: #856404;
        margin-bottom: 4px;
    }

    .commission-value-settings {
        font-size: 32px;
        font-weight: 700;
        color: #856404;
    }

    .btn-save-settings {
        width: 100%;
        padding: 14px 24px;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 15px;
        margin-top: 8px;
    }

    .btn-save-settings:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }

    .alert-success {
        background: #D4EDDA;
        border: 2px solid #28A745;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #155724;
        font-weight: 500;
    }

    .alert-success i {
        font-size: 20px;
    }

    .info-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .info-card-settings {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #872341;
    }

    .info-card-settings h6 {
        font-size: 15px;
        font-weight: 600;
        color: #09122C;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-card-settings p {
        font-size: 13px;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 768px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }

        .settings-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-view-salon {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid")
<!-- Header -->
    <div class="settings-header">
        <div class="settings-header-left">
            <h1><i class="bi bi-gear"></i> Settings</h1>
            <p>Configure your salon's business settings and preferences</p>
        </div>
        @if($salon->hasSubdomain())
            <a href="{{ $salon->subdomain_url }}" target="_blank" class="btn-view-salon">
                <i class="bi bi-eye"></i> View Public Page
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('salon.settings.update') }}" method="POST">
        @csrf

        <!-- Settings Grid -->
        <div class="settings-grid">
            <!-- Business Hours Card -->
            <div class="settings-card">
                <h5><i class="bi bi-clock-history"></i> Business Hours</h5>
                <p>Configure your salon's operating hours</p>

                <div class="form-group-settings">
                    <label for="opening_time">
                        Opening Time <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <input 
                            type="time" 
                            id="opening_time" 
                            name="opening_time" 
                            value="{{ old('opening_time', $salon->opening_time ?? '09:00') }}" 
                            required
                            class="form-control-settings @error('opening_time') is-invalid @enderror">
                        <i class="bi bi-clock input-icon"></i>
                    </div>
                    @error('opening_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group-settings">
                    <label for="closing_time">
                        Closing Time <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <input 
                            type="time" 
                            id="closing_time" 
                            name="closing_time" 
                            value="{{ old('closing_time', $salon->closing_time ?? '20:00') }}" 
                            required
                            class="form-control-settings @error('closing_time') is-invalid @enderror">
                        <i class="bi bi-clock input-icon"></i>
                    </div>
                    @error('closing_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <span class="form-help-text">These hours will be used to calculate available time slots for appointments</span>
                </div>

                <div class="form-group-settings">
                    <label>Working Days <span class="required">*</span></label>
                    @php
                        $workingDays = old('working_days', $salon->working_days ?? ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
                        $allDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    @endphp
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; margin-top: 8px;">
                        @foreach($allDays as $day)
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; border: 2px solid #e0e0e0; border-radius: 8px; transition: all 0.3s ease;" class="day-checkbox">
                                <input 
                                    type="checkbox" 
                                    name="working_days[]" 
                                    value="{{ $day }}" 
                                    {{ in_array($day, $workingDays) ? 'checked' : '' }}
                                    style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 14px; font-weight: 500; color: #09122C;">{{ ucfirst($day) }}</span>
                            </label>
                        @endforeach
                    </div>
                    <span class="form-help-text">Select the days your salon is open</span>
                </div>
            </div>

            <!-- Commission Settings Card -->
            <div class="settings-card">
                <h5><i class="bi bi-percent"></i> Commission Settings</h5>
                <p>Set the default commission rate for your salon</p>

                <div class="form-group-settings">
                    <label for="commission_percentage">
                        Salon Commission Percentage <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <input 
                            type="number" 
                            id="commission_percentage" 
                            name="commission_percentage" 
                            value="{{ old('commission_percentage', $salon->commission_percentage ?? 20) }}" 
                            min="0" 
                            max="100" 
                            step="0.01" 
                            required
                            class="form-control-settings @error('commission_percentage') is-invalid @enderror"
                            oninput="updateCommissionDisplay(this.value)">
                        <span class="input-icon">%</span>
                    </div>
                    @error('commission_percentage')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <span class="form-help-text">The percentage of each booking that goes to the salon (remaining goes to provider)</span>
                    
                    <div class="commission-display-settings">
                        <small>Commission Rate</small>
                        <div class="commission-value-settings" id="commissionDisplaySettings">
                            {{ old('commission_percentage', $salon->commission_percentage ?? 20) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="settings-card" style="margin-top: 24px;">
            <h5><i class="bi bi-share"></i> Social Media Links</h5>
            <p>Connect your social media profiles</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-settings">
                        <label for="facebook">
                            <i class="bi bi-facebook" style="color: #1877F2;"></i> Facebook
                        </label>
                        <input 
                            type="url" 
                            id="facebook" 
                            name="facebook" 
                            value="{{ old('facebook', $salon->facebook) }}" 
                            placeholder="https://facebook.com/yoursalon"
                            class="form-control-settings @error('facebook') is-invalid @enderror">
                        @error('facebook')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-settings">
                        <label for="instagram">
                            <i class="bi bi-instagram" style="color: #E4405F;"></i> Instagram
                        </label>
                        <input 
                            type="url" 
                            id="instagram" 
                            name="instagram" 
                            value="{{ old('instagram', $salon->instagram) }}" 
                            placeholder="https://instagram.com/yoursalon"
                            class="form-control-settings @error('instagram') is-invalid @enderror">
                        @error('instagram')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-settings">
                        <label for="twitter">
                            <i class="bi bi-twitter" style="color: #1DA1F2;"></i> Twitter
                        </label>
                        <input 
                            type="url" 
                            id="twitter" 
                            name="twitter" 
                            value="{{ old('twitter', $salon->twitter) }}" 
                            placeholder="https://twitter.com/yoursalon"
                            class="form-control-settings @error('twitter') is-invalid @enderror">
                        @error('twitter')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-settings">
                        <label for="youtube">
                            <i class="bi bi-youtube" style="color: #FF0000;"></i> YouTube
                        </label>
                        <input 
                            type="url" 
                            id="youtube" 
                            name="youtube" 
                            value="{{ old('youtube', $salon->youtube) }}" 
                            placeholder="https://youtube.com/@yoursalon"
                            class="form-control-settings @error('youtube') is-invalid @enderror">
                        @error('youtube')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-settings">
                        <label for="linkedin">
                            <i class="bi bi-linkedin" style="color: #0A66C2;"></i> LinkedIn
                        </label>
                        <input 
                            type="url" 
                            id="linkedin" 
                            name="linkedin" 
                            value="{{ old('linkedin', $salon->linkedin) }}" 
                            placeholder="https://linkedin.com/company/yoursalon"
                            class="form-control-settings @error('linkedin') is-invalid @enderror">
                        @error('linkedin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-settings">
                        <label for="website">
                            <i class="bi bi-globe" style="color: #667eea;"></i> Website
                        </label>
                        <input 
                            type="url" 
                            id="website" 
                            name="website" 
                            value="{{ old('website', $salon->website) }}" 
                            placeholder="https://www.yoursalon.com"
                            class="form-control-settings @error('website') is-invalid @enderror">
                        @error('website')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="settings-card">
            <button type="submit" class="btn-save-settings">
                <i class="bi bi-check-circle"></i> Save Settings
            </button>
        </div>
    </form>

    <!-- Info Cards -->
    <div class="info-cards-grid" style="margin-top: 24px;">
        <div class="info-card-settings">
            <h6><i class="bi bi-info-circle"></i> Business Hours</h6>
            <p>These operating hours will be used to calculate available appointment time slots for customers booking through your salon.</p>
        </div>

        <div class="info-card-settings" style="border-left-color: #28A745;">
            <h6><i class="bi bi-cash-stack"></i> Commission Rate</h6>
            <p>The commission rate applies to all providers unless they have individual rates set in their profile settings.</p>
        </div>

        <div class="info-card-settings" style="border-left-color: #007BFF;">
            <h6><i class="bi bi-calendar-check"></i> Appointments</h6>
            <p>Your settings affect booking availability and revenue calculations across the entire salon dashboard.</p>
        </div>
    </div>
</div>

<script>
    function updateCommissionDisplay(value) {
        const display = document.getElementById('commissionDisplaySettings');
        if (display) {
            display.textContent = value + '%';
        }
    }

    // Add hover effects for day checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        const dayCheckboxes = document.querySelectorAll('.day-checkbox');
        dayCheckboxes.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            
            // Set initial state
            if (checkbox.checked) {
                label.style.borderColor = '#872341';
                label.style.backgroundColor = 'rgba(135, 35, 65, 0.05)';
            }
            
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    label.style.borderColor = '#872341';
                    label.style.backgroundColor = 'rgba(135, 35, 65, 0.05)';
                } else {
                    label.style.borderColor = '#e0e0e0';
                    label.style.backgroundColor = 'transparent';
                }
            });
            
            label.addEventListener('mouseenter', function() {
                if (!checkbox.checked) {
                    label.style.borderColor = '#872341';
                }
            });
            
            label.addEventListener('mouseleave', function() {
                if (!checkbox.checked) {
                    label.style.borderColor = '#e0e0e0';
                }
            });
        });
    });
</script>
@endsection
