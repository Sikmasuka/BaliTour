@props([
    'title' => null,
    'subtitle' => null,
    'portal' => null
])

@php
    $currentRoute = Route::currentRouteName() ?? '';
    $currentPath = request()->path();

    // Auto-detect portal
    $isUserPortal = ($portal === 'user' || $portal === 'tourist') || str_starts_with($currentPath, 'user') || str_starts_with($currentPath, 'tourist') || str_starts_with($currentRoute, 'user.') || str_starts_with($currentRoute, 'tourist.');
    $isAdminPortal = !$isUserPortal;

    $pageTitle = $title ?? ($__env->yieldContent('title') ?: ($isUserPortal ? 'Dashboard' : 'Dashboard'));
    $pageSubtitle = $subtitle ?? ($__env->yieldContent('page-subtitle') ?: ($isUserPortal ? 'Traveler Portal' : 'Admin Panel'));

    $homeUrl = $isAdminPortal ? url('/admin/dashboard') : url('/user/dashboard');
    $homeLabel = $isAdminPortal ? 'Admin Panel' : 'Traveler Portal';
@endphp

<!-- Flat Clear Forest Breadcrumbs -->
<div class="w-full max-w-7xl mx-auto px-4 pt-4 pb-1 sm:px-6 sm:pt-6 sm:pb-2 lg:px-8">
  <div class="flex items-center justify-between gap-3 min-w-0">
    
    <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm font-medium text-forest-700 min-w-0 flex-wrap">
      
      <!-- Mobile Drawer Trigger (< 1024px) -->
      <button id="menuBtn" 
              type="button"
              aria-label="Open navigation menu" 
              class="flex lg:hidden items-center justify-center h-8 w-8 rounded-lg bg-forest-100 text-forest-950 hover:bg-forest-200 active:scale-95 transition-all focus:outline-hidden cursor-pointer mr-1">
        <svg class="h-4.5 w-4.5 text-forest-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <!-- Root Portal Link -->
      <a href="{{ $homeUrl }}" 
         class="inline-flex items-center gap-1.5 font-semibold text-forest-700 hover:text-forest-950 transition-colors shrink-0">
        <svg class="h-4 w-4 text-forest-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>{{ $homeLabel }}</span>
      </a>

      <!-- Separator 1 -->
      <svg class="h-3.5 w-3.5 text-mineral-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"/>
      </svg>

      @if(!empty($pageSubtitle) && strtolower($pageSubtitle) !== strtolower($pageTitle) && strtolower($pageSubtitle) !== strtolower($homeLabel))
        <!-- Subtitle / Section -->
        <span class="text-ink-600 font-medium shrink-0">
          {{ $pageSubtitle }}
        </span>

        <!-- Separator 2 -->
        <svg class="h-3.5 w-3.5 text-mineral-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"/>
        </svg>
      @endif

      <!-- Active Page Name -->
      <div class="flex items-center gap-1.5 font-bold text-forest-950 min-w-0">
        <span class="h-1.5 w-1.5 rounded-full bg-forest-700 shrink-0 animate-pulse"></span>
        <span class="truncate">{{ $pageTitle }}</span>
      </div>

    </nav>

    <!-- Header Right Actions & User Profile -->
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
      <!-- Live date indicator -->
      <div class="hidden lg:flex items-center gap-1.5 text-xs font-semibold text-ink-600 bg-white/70 border border-mineral-200/80 px-2.5 py-1 rounded-lg shadow-2xs">
        <svg class="h-3.5 w-3.5 text-forest-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
          <line x1="16" x2="16" y1="2" x2="6"/>
          <line x1="8" x2="8" y1="2" y2="6"/>
          <line x1="3" x2="21" y1="10" y2="10"/>
        </svg>
        <span>{{ now()->format('D, M j, Y') }}</span>
      </div>

      @auth
        @php
          $authUser = Auth::user();
          $authProfile = $authUser ? ($authUser->touristProfile ?? $authUser->profile) : null;
          $authName = $authProfile && $authProfile->first_name ? $authProfile->first_name : ($authUser ? explode(' ', $authUser->name ?? 'User')[0] : 'User');
          $authRole = $authUser ? ($authUser->role === 'admin' ? 'Admin' : 'Traveler') : 'Guest';
          
          $authInitials = 'U';
          if ($authUser) {
              $nameParts = explode(' ', trim($authUser->name ?? 'User'));
              $authInitials = count($nameParts) >= 2
                  ? strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1))
                  : strtoupper(substr($authUser->name ?? 'U', 0, 2));
          }
        @endphp
        <!-- Header User Pill & Quick Logout -->
        <div class="flex items-center gap-1.5 bg-white border border-mineral-200 rounded-xl p-1 shadow-2xs">
          <!-- Profile indicator -->
          <div class="flex items-center gap-2 px-1.5 py-0.5" title="Signed in as {{ $authUser->name }} ({{ $authRole }})">
            <div class="relative flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-forest-900 text-[10px] font-bold text-white shadow-2xs">
              {{ $authInitials }}
              <span class="absolute -top-0.5 -right-0.5 flex h-1.5 w-1.5">
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500 ring-1 ring-white"></span>
              </span>
            </div>
            <span class="hidden sm:inline text-xs font-semibold text-forest-950 max-w-[100px] truncate">{{ $authName }}</span>
          </div>

          <div class="h-4 w-px bg-mineral-200"></div>

          <!-- Header Quick Logout Button -->
          <button type="button" 
                  onclick="if(window.openLogoutModal){ window.openLogoutModal(event); }"
                  class="group flex items-center gap-1.5 px-2 py-1 rounded-lg text-ink-500 hover:text-rose-600 hover:bg-rose-50 transition-all text-xs font-medium cursor-pointer focus:outline-hidden"
                  title="Sign out of account"
                  aria-label="Sign out">
            <svg class="h-3.5 w-3.5 shrink-0 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
              <polyline points="16 17 21 12 16 7"/>
              <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            <span class="hidden md:inline text-[11px] font-semibold">Sign Out</span>
          </button>
        </div>
      @endauth
    </div>

  </div>
</div>
