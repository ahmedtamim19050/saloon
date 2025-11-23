<x-customer-dashboard title="My Profile">
<div class="mb-4">
    <h2 class="fw-bold">My Profile</h2>
    <p class="text-muted">View and manage your profile information</p>
</div>

<div class="row g-4">
    <!-- Profile Information -->
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-person-circle me-2"></i> Profile Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('customer.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="+880 1XXX-XXXXXX">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
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
    </div>

    <!-- Profile Stats -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle text-primary" style="font-size: 5rem;"></i>
                </div>
                <h5 class="fw-bold">{{ $customer->name }}</h5>
                <p class="text-muted mb-0">{{ $customer->email }}</p>
                <hr>
                <div class="d-flex justify-content-around text-center">
                    <div>
                        <h4 class="fw-bold text-primary">{{ $customer->appointments()->count() }}</h4>
                        <small class="text-muted">Bookings</small>
                    </div>
                    <div>
                        <h4 class="fw-bold text-success">{{ $customer->appointments()->where('status', 'completed')->count() }}</h4>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Account Details</h6>
                <div class="mb-2">
                    <small class="text-muted">Member Since</small>
                    <div class="fw-semibold">{{ $customer->created_at->format('M d, Y') }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Account Type</small>
                    <div class="fw-semibold">{{ ucfirst($customer->role) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-customer-dashboard>
