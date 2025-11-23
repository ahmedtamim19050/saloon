<x-customer-dashboard title="Settings">
<div class="row g-4">
    <!-- Profile Settings -->
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-person-circle me-2"></i> Profile Settings
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('customer.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="+880 1XXX-XXXXXX">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-shield-lock me-2"></i> Change Password
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('customer.password.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">At least 8 characters</small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-key me-2"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Notification Preferences & Account Settings -->
    <div class="col-lg-4">
        <!-- Notification Preferences -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-bell me-2"></i> Notifications
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('customer.notifications.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="email_notifications" 
                                   name="email_notifications" value="1" checked>
                            <label class="form-check-label" for="email_notifications">
                                <strong>Email Notifications</strong>
                                <small class="d-block text-muted">Receive appointment confirmations via email</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sms_notifications" 
                                   name="sms_notifications" value="1">
                            <label class="form-check-label" for="sms_notifications">
                                <strong>SMS Notifications</strong>
                                <small class="d-block text-muted">Get appointment reminders via SMS</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="promotional_emails" 
                                   name="promotional_emails" value="1">
                            <label class="form-check-label" for="promotional_emails">
                                <strong>Promotional Emails</strong>
                                <small class="d-block text-muted">Receive special offers and discounts</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="reminder_notifications" 
                                   name="reminder_notifications" value="1" checked>
                            <label class="form-check-label" for="reminder_notifications">
                                <strong>Appointment Reminders</strong>
                                <small class="d-block text-muted">24 hours before appointments</small>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info text-white w-100">
                        <i class="bi bi-save me-2"></i> Save Preferences
                    </button>
                </form>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-eye-slash me-2"></i> Privacy
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('customer.privacy.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="profile_visibility" 
                                   name="profile_visibility" value="1" checked>
                            <label class="form-check-label" for="profile_visibility">
                                <strong>Profile Visibility</strong>
                                <small class="d-block text-muted">Allow salons to see your booking history</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show_reviews" 
                                   name="show_reviews" value="1" checked>
                            <label class="form-check-label" for="show_reviews">
                                <strong>Public Reviews</strong>
                                <small class="d-block text-muted">Display your name on reviews</small>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-save me-2"></i> Save Privacy Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Account Actions -->
        <div class="card shadow-sm border-danger mt-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-exclamation-triangle me-2"></i> Danger Zone
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">Once you delete your account, there is no going back. Please be certain.</p>
                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash me-2"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i> Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you absolutely sure you want to delete your account? This action cannot be undone.</p>
                <p class="text-danger fw-semibold">All your data including:</p>
                <ul class="text-muted">
                    <li>Appointment history</li>
                    <li>Reviews</li>
                    <li>Payment records</li>
                    <li>Personal information</li>
                </ul>
                <p class="text-muted">will be permanently deleted.</p>
                
                <form method="POST" action="{{ route('customer.account.delete') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Enter your password to confirm:</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-2"></i> Yes, Delete My Account
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
</x-customer-dashboard>
