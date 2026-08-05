@php
  $hasRegisterErrors = $errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('password') || $errors->has('mobile_number') || $errors->has('city_municipality') || $errors->has('barangay');
@endphp

<div class="modal-overlay" id="accessModal" aria-hidden="true">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <button class="modal-close" type="button" aria-label="Close modal">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    
    <div class="modal-header">
      <div class="modal-brand-tag">
        <span class="brand-dot"></span> Balingasag Tourism Portal
      </div>
      <h2 id="modalTitle">Plan Your Visit</h2>
      <p id="modalSubtitle">Sign in or create an account to start bookmarking attractions and itineraries.</p>
    </div>

    <div class="modal-tabs" role="tablist">
      <button class="tab-button {{ $hasRegisterErrors ? '' : 'active' }}" type="button" role="tab" aria-selected="{{ $hasRegisterErrors ? 'false' : 'true' }}" data-target="loginTab">Sign In</button>
      <button class="tab-button {{ $hasRegisterErrors ? 'active' : '' }}" type="button" role="tab" aria-selected="{{ $hasRegisterErrors ? 'true' : 'false' }}" data-target="registerTab">Create Account</button>
    </div>

    <div class="modal-body-container">
      <!-- Login Panel -->
      <div class="tab-panel {{ $hasRegisterErrors ? '' : 'active' }}" id="loginTab" role="tabpanel">
        <form action="{{ route('login') }}" method="POST">
          @csrf

          @error('login')
            <div class="p-3 mb-3 text-xs font-medium text-red-700 bg-red-50 rounded-lg border border-red-200" role="alert">
              {{ $message }}
            </div>
          @enderror

          <div class="form-group">
            <label for="modalUsername">Email Address</label>
            <div class="input-container">
              <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              <input id="modalUsername" name="login" type="email" value="{{ old('login') }}" placeholder="e.g. maria@example.com" autocomplete="username" required>
            </div>
          </div>

          <div class="form-group">
            <div class="label-row">
              <label for="modalPassword">Password</label>
              <a href="#" class="forgot-link">Forgot password?</a>
            </div>
            <div class="input-container">
              <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              <input id="modalPassword" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>
              <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
          </div>

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" name="remember">
              <span class="custom-check"></span>
              <span>Remember me on this device</span>
            </label>
          </div>

          <button class="modal-submit" type="submit">
            <span>Sign In</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </button>
        </form>

        <div class="form-footer">
          <span>New to Balingasag Tourism?</span>
          <a class="modal-switch" href="#" data-switch="registerTab">Create an account</a>
        </div>
      </div>

      <!-- Register Panel -->
      <div class="tab-panel {{ $hasRegisterErrors ? 'active' : '' }}" id="registerTab" role="tabpanel">
        <form action="{{ route('register') }}" method="POST">
          @csrf

          <!-- Section 1: Personal Information -->
          <div class="form-section-header">
            <span class="section-title">Personal Details</span>
          </div>

          <!-- Name Row (First Name, Middle Name, Last Name) -->
          <div class="form-row name-row">
            <div class="form-group">
              <label for="modalFirstName">First Name</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input id="modalFirstName" name="first_name" type="text" value="{{ old('first_name') }}" placeholder="Maria" autocomplete="given-name" required>
              </div>
              @error('first_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="modalMiddleName">Middle <span class="optional-tag">(Opt.)</span></label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input id="modalMiddleName" name="middle_name" type="text" value="{{ old('middle_name') }}" placeholder="Cruz" autocomplete="additional-name">
              </div>
              @error('middle_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="modalLastName">Last Name</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input id="modalLastName" name="last_name" type="text" value="{{ old('last_name') }}" placeholder="Santos" autocomplete="family-name" required>
              </div>
              @error('last_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
          </div>

          <!-- Section 2: Contact & Location -->
          <div class="form-section-header">
            <span class="section-title">Contact & Location</span>
          </div>

          <!-- Contact Row (Mobile & Email) -->
          <div class="form-row">
            <div class="form-group">
              <label for="modalMobile">Mobile Number</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <input id="modalMobile" name="mobile_number" type="tel" value="{{ old('mobile_number') }}" placeholder="0917 123 4567" autocomplete="tel" required>
              </div>
              @error('mobile_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="modalEmail">Email Address</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <input id="modalEmail" name="email" type="email" value="{{ old('email') }}" placeholder="maria@example.com" autocomplete="email" required>
              </div>
              @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
          </div>

          <!-- Location Row (City & Barangay) -->
          <div class="form-row">
            <div class="form-group">
              <label for="modalCity">City / Municipality</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <select id="modalCity" name="city_municipality" data-old="{{ old('city_municipality', 'Balingasag') }}" class="w-full bg-transparent outline-none cursor-pointer pr-2" required>
                  <option value="">Loading Cities...</option>
                </select>
              </div>
              @error('city_municipality') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="modalBarangay">Barangay</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <select id="modalBarangay" name="barangay" data-old="{{ old('barangay') }}" class="w-full bg-transparent outline-none cursor-pointer pr-2" required disabled>
                  <option value="">Select City First...</option>
                </select>
              </div>
              @error('barangay') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
          </div>

          <!-- Section 3: Account Security -->
          <div class="form-section-header">
            <span class="section-title">Account Security</span>
          </div>

          <!-- Password Row -->
          <div class="form-row">
            <div class="form-group">
              <label for="modalNewPassword">Password</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input id="modalNewPassword" name="password" type="password" placeholder="Create password" autocomplete="new-password" required>
                <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                  <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
              </div>
              @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="modalConfirmPassword">Confirm Password</label>
              <div class="input-container">
                <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input id="modalConfirmPassword" name="password_confirmation" type="password" placeholder="Confirm password" autocomplete="new-password" required>
                <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                  <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
              </div>
            </div>
          </div>

          <div class="form-options mt-1">
            <label class="checkbox-label">
              <input type="checkbox" name="terms" required>
              <span>I agree to the <a href="#" class="terms-link">Terms of Service</a> & <a href="#" class="terms-link">Privacy Policy</a></span>
            </label>
          </div>

          <button class="modal-submit mt-1" type="submit">
            <span>Create Account</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </button>
        </form>

        <div class="form-footer">
          <span>Already have an account?</span>
          <a class="modal-switch" href="#" data-switch="loginTab">Sign in instead</a>
        </div>
      </div>
    </div>
  </div>
</div>
