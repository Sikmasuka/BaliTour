@php
  $user = Auth::user();
  $profile = $user ? ($user->touristProfile ?? $user->profile) : null;
  $name = $profile && $profile->first_name ? $profile->first_name . ' ' . $profile->last_name : ($user ? $user->name : 'User');
  $email = $user ? ($user->email ?? $user->username) : '';
  $role = $user ? ($user->role === 'admin' ? 'Administrator' : 'Traveler') : 'Guest';
  
  $initials = 'U';
  if ($user) {
      $parts = explode(' ', trim($name));
      $initials = count($parts) >= 2
          ? strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1))
          : strtoupper(substr($name, 0, 2));
  }
@endphp

<!-- Modern Glassmorphic Logout Confirmation Modal -->
<div id="logoutConfirmationModal" 
     class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md transition-all duration-200 ease-out opacity-0 invisible pointer-events-none"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="logoutModalTitle"
     aria-describedby="logoutModalDesc">

  <!-- Modal Dialog Box -->
  <div id="logoutModalCard"
       class="relative w-full max-w-[420px] bg-white text-slate-900 rounded-2xl border border-slate-200/90 shadow-2xl p-6 sm:p-7 flex flex-col items-center text-center transition-all duration-200 ease-out transform scale-95 opacity-0 overflow-hidden">
    
    <!-- Top Rose to Forest Accent Gradient Bar -->
    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-rose-500 via-amber-500 to-forest-600 rounded-t-2xl"></div>

    <!-- Close Button Top-Right -->
    <button type="button" 
            onclick="window.closeLogoutModal()"
            class="absolute top-3.5 right-3.5 flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors focus:outline-hidden cursor-pointer"
            aria-label="Close dialog">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    <!-- Logout Icon Emblem with Ambient Glow -->
    <div class="relative my-2 flex items-center justify-center">
      <div class="absolute -inset-2 rounded-full bg-rose-500/10 blur-sm pointer-events-none"></div>
      <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 shadow-xs ring-4 ring-rose-50/60">
        <svg class="h-7 w-7 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
      </div>
    </div>

    <!-- Title & Description -->
    <h3 id="logoutModalTitle" class="mt-2 text-xl font-bold text-slate-900 tracking-tight">
      Sign Out of BaliTour?
    </h3>
    <p id="logoutModalDesc" class="mt-1.5 text-xs sm:text-sm text-slate-500 font-normal leading-relaxed max-w-[320px]">
      Are you sure you want to end your current session? You will need to sign in again to access your dashboard.
    </p>

    <!-- User Identity Snapshot Pill -->
    <div class="mt-4 w-full flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-left">
      <div class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-forest-900 text-xs font-bold text-white shadow-2xs">
        {{ $initials }}
        <span class="absolute -bottom-0.5 -right-0.5 flex h-2.5 w-2.5">
          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 ring-2 ring-white"></span>
        </span>
      </div>
      <div class="flex-1 min-w-0">
        <p class="truncate text-xs font-bold text-slate-900 leading-tight">{{ $name }}</p>
        <div class="flex items-center gap-1.5 mt-0.5">
          <span class="text-[10px] font-medium text-slate-500 truncate">{{ $email }}</span>
          <span class="text-slate-300 text-[8px]">•</span>
          <span class="text-[10px] font-semibold text-forest-700">{{ $role }}</span>
        </div>
      </div>
    </div>

    <!-- Actions Form -->
    <form id="logoutModalForm" method="POST" action="{{ route('logout') }}" class="mt-5 w-full flex items-center gap-3">
      @csrf
      <!-- Cancel Button -->
      <button type="button" 
              id="logoutCancelBtn"
              onclick="window.closeLogoutModal()"
              class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold transition-all shadow-2xs hover:shadow-xs active:scale-[0.98] focus:outline-hidden cursor-pointer">
        Cancel
      </button>

      <!-- Confirm Sign Out Button -->
      <button type="submit" 
              id="logoutConfirmBtn"
              class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white text-xs sm:text-sm font-semibold transition-all shadow-md shadow-rose-600/20 hover:shadow-lg hover:shadow-rose-600/30 active:scale-[0.98] focus:outline-hidden cursor-pointer">
        <svg id="logoutSpinner" class="hidden h-4 w-4 animate-spin text-white" viewBox="0 0 24 24" fill="none">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span id="logoutBtnText">Sign Out</span>
      </button>
    </form>

  </div>
</div>
