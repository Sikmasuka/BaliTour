<aside id="userSidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full transform flex-col bg-forest-900 text-cream-100 transition-transform duration-200 lg:translate-x-0">
  <div class="flex items-center px-6 py-6">
    <a href="/" class="block" aria-label="BaliTour Home">
      <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="h-11 w-auto object-contain">
    </a>
  </div>
  <div class="mx-6 h-px bg-white/10"></div>
  <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="User navigation">
    <p class="px-2 pb-2 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Overview</p>
    <a href="/user/dashboard" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('dashboard-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
      Dashboard
    </a>
    <a href="/user/explore-places" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('explore-places-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      Explore Places
    </a>
    <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Account</p>
    <a href="/user/edit-profile" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('edit-profile-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a4 4 0 1 1-5.66 5.66L12 12l-4 4-1 4h4l4-4 2.83-2.83A4 4 0 1 1 16.5 3.5Z"/></svg>
      Edit Profile
    </a>
    <a href="/user/bookmarks" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('bookmarks-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 4h12a2 2 0 0 1 2 2v16l-8-4-8 4V6a2 2 0 0 1 2-2Z"/></svg>
      Bookmarks
    </a>
    <a href="/user/booking-history" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('booking-history-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 7h10"/><path d="M7 11h10"/><path d="M7 15h7"/><path d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/></svg>
      Travel List
    </a>
    <a href="/user/reviews" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('reviews-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.1-5.4 3.1 1.3-6-4.6-4.1 6.1-.6L12 3Z"/></svg>
      Leave Reviews
    </a>
    <a href="/user/notifications" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('notifications-active')">
      <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
      Notifications
    </a>
  </nav>
  <div class="border-t border-white/10 px-4 py-4">
    <div class="flex items-center gap-3 rounded-xl px-2 py-2 transition hover:bg-white/5">
      @auth
        @php
          $user = Auth::user();
          $profile = $user->profile;
          $name = $profile ? trim($profile->first_name . ' ' . $profile->last_name) : ($user->name ?? 'User');
          $initials = $profile 
            ? (strtoupper(substr($profile->first_name ?? 'U', 0, 1) . substr($profile->last_name ?? 'S', 0, 1))) 
            : strtoupper(substr($user->email ?? 'US', 0, 2));
          $role = ucfirst($user->role ?? 'Traveler');
        @endphp
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sage-400 text-xs font-semibold text-forest-900 shadow-sm">
          {{ $initials }}
        </div>
        <div class="min-w-0 flex-1">
          <p class="truncate text-sm font-medium text-cream-50" title="{{ $name }}">{{ $name }}</p>
          <p class="truncate text-xs text-cream-100/60">{{ $role }}</p>
        </div>
      @else
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sage-400 text-xs font-semibold text-forest-900 shadow-sm">MS</div>
        <div class="min-w-0 flex-1">
          <p class="truncate text-sm font-medium text-cream-50">Maria Santos</p>
          <p class="truncate text-xs text-cream-100/60">Traveler</p>
        </div>
      @endauth

      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" title="Sign out" class="flex items-center justify-center p-1.5 rounded-lg text-cream-100/60 hover:text-red-400 hover:bg-white/10 transition cursor-pointer" aria-label="Sign out">
          <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4M16 17l5-5-5-5M21 12H9"/>
          </svg>
        </button>
      </form>
    </div>
  </div>
</aside>