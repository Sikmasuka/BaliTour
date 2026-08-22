@php
  $lockoutSeconds = session('lockout_seconds') ?? 0;
  $isLocked = session('is_locked') || $lockoutSeconds > 0;
  $hasRegisterErrors = $errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('mobile_number') || $errors->has('city_municipality') || $errors->has('barangay') || ($errors->has('username') && old('first_name') !== null);
  
  $hasLoginErrors = ($errors->has('username') && old('first_name') === null) || $errors->has('login') || $errors->has('password') || $errors->has('login_error') || session('error') || $isLocked;
  
  $hasAnyAuthErrors = $hasRegisterErrors || $hasLoginErrors || $errors->any() || session('error') || $isLocked;
  
  $initialStep = 1;
  if ($errors->has('password') || $errors->has('username')) {
      $initialStep = 2;
  } elseif ($errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('mobile_number') || $errors->has('barangay')) {
      $initialStep = 1;
  }
@endphp

<!-- Modal Overlay (Persists open automatically when validation errors exist) -->
<div class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-4 bg-slate-950/70 backdrop-blur-md transition-all duration-300 ease-out modal-overlay {{ $hasAnyAuthErrors ? 'opacity-100 visible pointer-events-auto' : 'opacity-0 invisible pointer-events-none' }}" id="accessModal" aria-hidden="{{ $hasAnyAuthErrors ? 'false' : 'true' }}">
  <!-- Modal Content Card (Compact Height, Wide Horizontal Desktop Sizing) -->
  <div class="relative w-full {{ $hasRegisterErrors ? 'max-w-[480px] sm:max-w-[580px] md:max-w-[660px]' : 'max-w-[440px]' }} bg-white text-slate-800 rounded-2xl border border-slate-200/90 shadow-2xl p-4 sm:p-5 md:p-6 flex flex-col transition-all duration-300 ease-out modal-box {{ $hasAnyAuthErrors ? 'scale-100 opacity-100' : 'scale-95 opacity-0' }}" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    
    <!-- Decorative Top Accent Line -->
    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-t-2xl"></div>

    <!-- Close Button -->
    <button class="absolute top-3.5 right-3.5 sm:top-4 sm:right-4 w-7 h-7 rounded-full bg-slate-100/80 text-slate-500 hover:bg-emerald-800 hover:text-white flex items-center justify-center transition-all duration-200 cursor-pointer z-10 modal-close" type="button" aria-label="Close modal">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    
    <!-- Header Logo (Highlighted & Centered) -->
    <div class="mb-3 shrink-0 flex flex-col items-center justify-center text-center pt-0.5">
      <div class="relative mb-1.5 flex items-center justify-center">
        <div class="absolute -inset-1 rounded-2xl bg-emerald-500/15 blur-xs pointer-events-none"></div>
        <div class="relative px-3.5 py-1.5 rounded-2xl bg-white border border-emerald-200/90 shadow-2xs ring-3 ring-emerald-50 flex items-center justify-center">
          <img src="/Logo/BaliTourLogo.png" alt="BaliTour Logo" class="h-8 sm:h-9 w-auto object-contain drop-shadow-xs" onerror="this.src='/Logo/BTLogo.png'">
        </div>
      </div>
      <p class="text-xs text-slate-500 font-normal">Welcome! Sign in or create your account to explore.</p>
    </div>

    <!-- Tab Buttons (Clean Segmented Control) -->
    <div class="flex bg-slate-100 p-1 rounded-xl mb-3 shrink-0 modal-tabs border border-slate-200/70" role="tablist">
      <button class="tab-button flex-1 py-1.5 text-xs rounded-lg transition-all {{ $hasRegisterErrors ? 'text-slate-600 font-medium hover:text-slate-900' : 'active bg-emerald-800 text-white shadow-sm font-semibold' }}" type="button" role="tab" aria-selected="{{ $hasRegisterErrors ? 'false' : 'true' }}" data-target="loginTab">Sign In</button>
      <button class="tab-button flex-1 py-1.5 text-xs rounded-lg transition-all {{ $hasRegisterErrors ? 'active bg-emerald-800 text-white shadow-sm font-semibold' : 'text-slate-600 font-medium hover:text-slate-900' }}" type="button" role="tab" aria-selected="{{ $hasRegisterErrors ? 'true' : 'false' }}" data-target="registerTab">Create Account</button>
    </div>

    <!-- Body Container -->
    <div class="relative flex-1 modal-body-container">
      
      <!-- Login Panel -->
      <div class="tab-panel transition-all duration-300 {{ $hasRegisterErrors ? 'hidden absolute inset-x-0 top-0 h-0 overflow-hidden opacity-0 pointer-events-none' : 'block relative opacity-100' }}" id="loginTab" role="tabpanel">
        <form action="{{ route('login') }}" method="POST" class="space-y-3">
          @csrf

          @if ($isLocked && $lockoutSeconds > 0)
            <!-- Dedicated Locked Account Alert UI with Working Countdown -->
            <div id="lockoutAlertBox" class="p-3 rounded-xl bg-amber-500/[0.08] border border-amber-400/40 text-amber-950 space-y-2.5 animate-shake shadow-2xs">
              <div class="flex items-start gap-2.5">
                <div class="shrink-0 w-7 h-7 rounded-lg bg-amber-500/20 text-amber-700 flex items-center justify-center ring-2 ring-amber-500/20 mt-0.5">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-2">
                    <h4 class="font-bold text-xs text-amber-950">Account Temporarily Locked</h4>
                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[9.5px] font-bold bg-amber-500/20 text-amber-800 ring-1 ring-amber-600/20">Security Lock</span>
                  </div>
                  <p class="text-[11px] text-amber-900/85 mt-0.5 leading-tight">
                    Too many failed login attempts. Sign-in is temporarily paused.
                  </p>
                </div>
              </div>

              <!-- Live Countdown Display & Progress Meter -->
              <div class="bg-white/90 rounded-lg px-2.5 py-2 border border-amber-300/50 flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                  <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                  </span>
                  <span class="text-[11px] font-medium text-slate-600">Try again in:</span>
                </div>
                <div class="flex items-center gap-1.5 font-mono text-xs font-bold text-amber-950 bg-amber-100/80 px-2 py-0.5 rounded-md border border-amber-300/60" id="lockoutTimerContainer" data-seconds="{{ $lockoutSeconds }}">
                  <svg class="w-3.5 h-3.5 text-amber-700 animate-spin" style="animation-duration: 3s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  <span id="lockoutCountdownText">--:--</span>
                </div>
              </div>
            </div>
          @elseif ($hasLoginErrors)
            <div id="modalLoginErrorAlert" class="p-2.5 text-xs font-medium rounded-xl bg-rose-50 border border-rose-200 flex items-center gap-2 text-rose-700 animate-shake" role="alert">
              <svg class="w-4 h-4 text-rose-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
              <span>{{ $errors->first('login_error') ?: ($errors->first('username') ?: ($errors->first('password') ?: ($errors->first('login') ?: (session('error') ?: 'Credentials incorrect.')))) }}</span>
            </div>
          @endif

          <!-- Username -->
          <div class="space-y-0.5">
            <label for="modalLoginUsername" class="block text-xs font-medium text-slate-700">Username</label>
            <div class="relative flex items-center">
              <svg class="absolute left-3 w-4 h-4 {{ $hasLoginErrors ? 'text-rose-400' : 'text-slate-400' }} pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              <input id="modalLoginUsername" name="username" type="text" value="{{ old('username', old('login')) }}" placeholder="Enter your username" autocomplete="username" required
                {{ $isLocked && $lockoutSeconds > 0 ? 'disabled' : '' }}
                class="w-full h-9.5 pl-9 pr-3 {{ $hasLoginErrors ? 'border-rose-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 bg-rose-50/10' : 'border-slate-200 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 bg-white' }} {{ $isLocked && $lockoutSeconds > 0 ? 'opacity-65 cursor-not-allowed bg-slate-50' : '' }} border rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 outline-none transition-all shadow-xs">
            </div>
          </div>

          <!-- Password -->
          <div class="space-y-0.5">
            <div class="flex justify-between items-center">
              <label for="modalPassword" class="block text-xs font-medium text-slate-700">Password</label>
              <a href="#" class="text-xs font-medium text-emerald-700 hover:text-emerald-800 underline transition-colors">Forgot password?</a>
            </div>
            <div class="relative flex items-center">
              <svg class="absolute left-3 w-4 h-4 {{ $hasLoginErrors ? 'text-rose-400' : 'text-slate-400' }} pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              <input id="modalPassword" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required
                {{ $isLocked && $lockoutSeconds > 0 ? 'disabled' : '' }}
                class="w-full h-9.5 pl-9 pr-9 {{ $hasLoginErrors ? 'border-rose-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 bg-rose-50/10' : 'border-slate-200 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 bg-white' }} {{ $isLocked && $lockoutSeconds > 0 ? 'opacity-65 cursor-not-allowed bg-slate-50' : '' }} border rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 outline-none transition-all shadow-xs">
              <button type="button" class="toggle-password absolute right-2.5 p-1 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer" aria-label="Toggle password visibility">
                <svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
          </div>

          <!-- Remember me -->
          <div class="flex items-center pt-0.5">
            <label class="inline-flex items-center gap-2 text-xs font-normal text-slate-600 cursor-pointer select-none">
              <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600 accent-emerald-700 cursor-pointer">
              <span>Remember me on this device</span>
            </label>
          </div>

          <!-- Submit Button -->
          <button id="loginSubmitBtn" class="w-full h-9.5 mt-0.5 {{ $isLocked && $lockoutSeconds > 0 ? 'bg-slate-400 cursor-not-allowed opacity-75' : 'bg-emerald-800 hover:bg-emerald-900 cursor-pointer' }} text-white font-medium text-xs rounded-xl shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 modal-submit-btn" type="submit" {{ $isLocked && $lockoutSeconds > 0 ? 'disabled' : '' }}>
            <span class="btn-text flex items-center justify-center gap-2">
              <span id="loginSubmitBtnText">{{ $isLocked && $lockoutSeconds > 0 ? 'Sign In Locked' : 'Sign In' }}</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </span>
            <span class="btn-spinner hidden items-center justify-center gap-2">
              <svg class="animate-spin h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>Verifying credentials...</span>
            </span>
          </button>
        </form>

        <div class="mt-3 pt-2.5 border-t border-slate-100 text-center text-xs text-slate-500 font-normal">
          <span>New to Balingasag Tourism?</span>
          <a class="modal-switch font-medium text-emerald-700 hover:text-emerald-800 underline ml-1 cursor-pointer" data-switch="registerTab">Create an account</a>
        </div>
      </div>

      <!-- Register Panel (Stepper) -->
      <div class="tab-panel transition-all duration-300 {{ $hasRegisterErrors ? 'block relative opacity-100' : 'hidden absolute inset-x-0 top-0 h-0 overflow-hidden opacity-0 pointer-events-none' }}" id="registerTab" role="tabpanel" data-initial-step="{{ $initialStep }}">
        
        <!-- Stepper Progress Header -->
        <div class="mb-3 bg-slate-50 border border-slate-200/80 rounded-xl p-2 sm:p-2.5">
          <div class="flex items-center justify-between max-w-[280px] sm:max-w-xs mx-auto relative px-3">
            <!-- Connecting Line Track Behind Bubbles -->
            <div class="absolute top-3 left-7 right-7 h-0.5 bg-slate-200 z-0 overflow-hidden rounded-full">
              <!-- Active Progress Fill -->
              <div id="stepperProgressBar" class="h-full bg-emerald-800 transition-all duration-300 ease-out" style="width: 0%;"></div>
            </div>

            <!-- Step 1 Node -->
            <div class="stepper-node flex flex-col items-center relative z-10" data-step="1">
              <div class="step-bubble w-6 h-6 rounded-full bg-emerald-800 text-white font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all shadow-xs">1</div>
              <span class="step-label text-[10px] font-medium text-slate-700 mt-0.5">Personal Info</span>
            </div>

            <!-- Step 2 Node -->
            <div class="stepper-node flex flex-col items-center relative z-10" data-step="2">
              <div class="step-bubble w-6 h-6 rounded-full bg-slate-200 text-slate-600 font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all">2</div>
              <span class="step-label text-[10px] font-medium text-slate-400 mt-0.5">Security</span>
            </div>
          </div>
        </div>

        <form action="{{ route('register') }}" method="POST" id="stepperForm" class="space-y-2.5">
          @csrf

          <!-- STEP 1: MERGED PERSONAL INFO & CONTACT -->
          <div class="step-content space-y-2.5" id="stepContent1">
            <!-- First & Last Name Grid (Wide Horizontal Gap on Desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-5 md:gap-x-6 gap-y-2">
              <div class="space-y-0.5">
                <label for="modalFirstName" class="block text-xs font-medium text-slate-700">First Name</label>
                <input id="modalFirstName" name="first_name" type="text" value="{{ old('first_name') }}" placeholder="Maria" autocomplete="given-name" required
                  class="w-full h-9.5 px-3.5 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
                @error('first_name') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-0.5">
                <label for="modalLastName" class="block text-xs font-medium text-slate-700">Last Name</label>
                <input id="modalLastName" name="last_name" type="text" value="{{ old('last_name') }}" placeholder="Santos" autocomplete="family-name" required
                  class="w-full h-9.5 px-3.5 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
                @error('last_name') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>
            </div>

            <!-- Email Address & Mobile Grid (Wide Horizontal Gap on Desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-5 md:gap-x-6 gap-y-2">
              <div class="space-y-0.5">
                <label for="modalEmail" class="block text-xs font-medium text-slate-700">Email Address</label>
                <input id="modalEmail" name="email" type="email" value="{{ old('email') }}" placeholder="maria@example.com" autocomplete="email" required
                  class="w-full h-9.5 px-3.5 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
                @error('email') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-0.5">
                <label for="modalMobile" class="block text-xs font-medium text-slate-700">Mobile Number</label>
                <input id="modalMobile" name="mobile_number" type="tel" value="{{ old('mobile_number') }}" placeholder="09171234567" autocomplete="tel" required
                  class="w-full h-9.5 px-3.5 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
                @error('mobile_number') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>
            </div>

            <!-- Location Grid (Wide Horizontal Gap on Desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-5 md:gap-x-6 gap-y-2">
              <div class="space-y-0.5">
                <label for="modalCity" class="block text-xs font-medium text-slate-700">City / Municipality</label>
                <div class="relative flex items-center">
                  <select id="modalCity" name="city_municipality" data-old="{{ old('city_municipality', 'Balingasag') }}" required
                    class="w-full h-9.5 pl-3.5 pr-8 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all appearance-none cursor-pointer shadow-xs">
                    <option value="">Loading...</option>
                  </select>
                  <svg class="absolute right-3 w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                @error('city_municipality') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>

              <div class="space-y-0.5">
                <label for="modalBarangay" class="block text-xs font-medium text-slate-700">Barangay</label>
                <div class="relative flex items-center">
                  <select id="modalBarangay" name="barangay" data-old="{{ old('barangay') }}" required disabled
                    class="w-full h-9.5 pl-3.5 pr-8 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all appearance-none cursor-pointer shadow-xs disabled:bg-slate-50 disabled:text-slate-400">
                    <option value="">Select City First...</option>
                  </select>
                  <svg class="absolute right-3 w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                @error('barangay') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>
            </div>

            <!-- Step 1 Action -->
            <div class="pt-1">
              <button type="button" class="btn-next-step w-full h-9.5 bg-emerald-800 hover:bg-emerald-900 text-white font-medium text-xs rounded-xl shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer" data-next="2">
                <span>Continue to Security</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </button>
            </div>
          </div>

          <!-- STEP 2: ACCOUNT SECURITY & CREDENTIALS -->
          <div class="step-content space-y-2.5 hidden" id="stepContent2">
            <!-- Username -->
            <div class="space-y-0.5">
              <label for="modalRegisterUsername" class="block text-xs font-medium text-slate-700">Username</label>
              <div class="relative flex items-center">
                <svg class="absolute left-3 w-4 h-4 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input id="modalRegisterUsername" name="username" type="text" value="{{ old('username') }}" placeholder="Choose a username (e.g. maria_santos)" autocomplete="username" required
                  class="w-full h-9.5 pl-9 pr-3 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
              </div>
              @error('username') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
            </div>

            <!-- Password & Confirm Password Grid on Tablet/Desktop -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-5 md:gap-x-6 gap-y-2">
              <!-- Password -->
              <div class="space-y-0.5">
                <label for="modalNewPassword" class="block text-xs font-medium text-slate-700">Password</label>
                <div class="relative flex items-center">
                  <svg class="absolute left-3 w-4 h-4 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                  <input id="modalNewPassword" name="password" type="password" placeholder="Create password" autocomplete="new-password" required
                    class="w-full h-9.5 pl-9 pr-9 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
                  <button type="button" class="toggle-password absolute right-2.5 p-1 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer" aria-label="Toggle password visibility">
                    <svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                  </button>
                </div>
                @error('password') <span class="text-[11px] text-rose-600 font-medium block">{{ $message }}</span> @enderror
              </div>

              <!-- Confirm Password -->
              <div class="space-y-0.5">
                <label for="modalConfirmPassword" class="block text-xs font-medium text-slate-700">Confirm Password</label>
                <div class="relative flex items-center">
                  <svg class="absolute left-3 w-4 h-4 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                  <input id="modalConfirmPassword" name="password_confirmation" type="password" placeholder="Confirm password" autocomplete="new-password" required
                    class="w-full h-9.5 pl-9 pr-9 bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 placeholder-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/15 outline-none transition-all shadow-xs">
                  <button type="button" class="toggle-password absolute right-2.5 p-1 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer" aria-label="Toggle password visibility">
                    <svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- Terms -->
            <div class="pt-0.5">
              <label class="inline-flex items-start gap-2 text-xs font-normal text-slate-600 cursor-pointer select-none">
                <input type="checkbox" name="terms" required class="w-3.5 h-3.5 mt-0.5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600 accent-emerald-700 cursor-pointer">
                <span>I agree to the <a href="#" class="font-medium text-emerald-700 hover:text-emerald-800 underline">Terms of Service</a> & <a href="#" class="font-medium text-emerald-700 hover:text-emerald-800 underline">Privacy Policy</a></span>
              </label>
            </div>

            <!-- Step 2 Actions -->
            <div class="flex gap-2.5 pt-1">
              <button type="button" class="btn-prev-step w-1/4 sm:w-1/5 h-9.5 bg-slate-100/90 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-xl transition-all cursor-pointer border border-slate-200" data-prev="1">
                ← Back
              </button>
              <button class="flex-1 h-9.5 bg-emerald-800 hover:bg-emerald-900 text-white font-medium text-xs rounded-xl shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed modal-submit-btn" type="submit">
                <span class="btn-text flex items-center justify-center gap-2">
                  <span>Create Account</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </span>
                <span class="btn-spinner hidden items-center justify-center gap-2">
                  <svg class="animate-spin h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span>Creating account...</span>
                </span>
              </button>
            </div>
          </div>
        </form>

        <div class="mt-3 pt-2.5 border-t border-slate-100 text-center text-xs text-slate-500 font-normal">
          <span>Already have an account?</span>
          <a class="modal-switch font-medium text-emerald-700 hover:text-emerald-800 underline ml-1 cursor-pointer" data-switch="loginTab">Sign in instead</a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @keyframes modalShake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-4px); }
    40%, 80% { transform: translateX(4px); }
  }
  .animate-shake {
    animation: modalShake 0.35s ease-in-out;
  }
</style>
