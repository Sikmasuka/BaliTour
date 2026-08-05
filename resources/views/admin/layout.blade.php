<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Municipality of Balingasag admin panel.">
  <title>{{ $title ?? 'Balingasag Admin' }}</title>
  <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            forest: { 900: '#152C24', 800: '#1B3A2E', 700: '#234A3A', 600: '#2C5B47' },
            sage:   { 400: '#A9C79B', 300: '#C4DAB8' },
            cream:  { 50: '#FBF9F3', 100: '#F5F1E7', 200: '#EBE4D2' },
            ink:    { 900: '#1B241E', 600: '#5B6A5D', 400: '#8A968A' },
          },
          fontFamily: {
            serif: ['"Playfair Display"', 'serif'],
            sans: ['Inter', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Playfair Display', serif; }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-thumb { background: #C4DAB8; border-radius: 999px; }
    ::-webkit-scrollbar-track { background: transparent; }
    a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible { outline: 2px solid #A9C79B; outline-offset: 2px; }
  </style>
</head>
<body class="min-h-screen bg-cream-50 text-ink-900">
  <div class="flex min-h-screen">
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full transform flex-col bg-forest-900 text-cream-100 transition-transform duration-200 lg:translate-x-0">
      <div class="flex items-center px-6 py-6">
        <a href="/" class="block" aria-label="BaliTour Home">
          <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="h-11 w-auto object-contain">
        </a>
      </div>
      <div class="mx-6 h-px bg-white/10"></div>
      <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="Admin navigation">
        <p class="px-2 pb-2 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Overview</p>
        <a href="/admin/dashboard" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('dashboard-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
          Dashboard
        </a>
        <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Content</p>
        <a href="/admin/destinations" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('destinations-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
          Manage Destinations
        </a>
        <a href="/admin/events" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('events-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
          Manage Events
        </a>
        <a href="/admin/reviews" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('reviews-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m12 3 2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.1-5.4 3.1 1.3-6-4.6-4.1 6.1-.6L12 3Z"/></svg>
          Manage Reviews
        </a>
        <a href="/admin/users" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('users-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.2"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16.5 5.5a3.2 3.2 0 0 1 0 6.3M21.5 20a5.8 5.8 0 0 0-5-6"/></svg>
          Manage Users
        </a>
        <a href="/admin/bookings" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('bookings-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M9 3v3M15 3v3M8.5 12.5l2.2 2.2L15.5 10"/></svg>
          Manage Bookings
        </a>
        <a href="/admin/messages" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('messages-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
          Contact Messages
          <span class="ml-auto rounded-full bg-sage-400 px-2 py-0.5 text-[10px] font-semibold text-forest-900">2</span>
        </a>
        <a href="/admin/balingasag-gallery" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('balingasag-gallery-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h18v14H3z"/><path d="M3 9h18"/><path d="M8 14l2-2 2 2 2-2 2 2"/></svg>
          Balingasag Gallery
        </a>
        <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">System</p>
        <a href="/admin/system-logs" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('system-logs-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="m7 9 3 3-3 3M13 15h4"/></svg>
          System Logs
        </a>
        <a href="/admin/security-logs" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('security-logs-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 4.5 6v6c0 4.6 3.2 7.9 7.5 9 4.3-1.1 7.5-4.4 7.5-9V6L12 3Z"/><path d="m9.5 12 1.8 1.8L15 10"/></svg>
          Security Logs
        </a>
        <a href="/admin/settings" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/5 hover:text-cream-50 @yield('settings-active')">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 13.5a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V20a2 2 0 1 1-4 0v-.2a1.7 1.7 0 0 0-1.1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H4a2 2 0 1 1 0-4h.2a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H10a1.7 1.7 0 0 0 1-1.6V4a2 2 0 1 1 4 0v.2a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V10a1.7 1.7 0 0 0 1.6 1H20a2 2 0 1 1 0 4h-.2a1.7 1.7 0 0 0-1.6 1Z"/></svg>
          Settings
        </a>
      </nav>
      <div class="border-t border-white/10 px-4 py-4">
        <div class="flex items-center gap-3 rounded-xl px-2 py-2 transition hover:bg-white/5">
          @auth
            @php
              $user = Auth::user();
              $profile = $user->profile;
              $name = $profile ? trim($profile->first_name . ' ' . $profile->last_name) : ($user->name ?? 'Admin User');
              $initials = $profile 
                ? (strtoupper(substr($profile->first_name ?? 'A', 0, 1) . substr($profile->last_name ?? 'D', 0, 1))) 
                : strtoupper(substr($user->email ?? 'AD', 0, 2));
              $role = ucfirst($user->role ?? 'Administrator');
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
              <p class="truncate text-xs text-cream-100/60">Administrator</p>
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

    <div id="overlay" class="fixed inset-0 z-30 hidden bg-forest-900/40 lg:hidden"></div>
    <div class="flex min-h-screen w-full flex-col lg:pl-72">
      <header class="sticky top-0 z-20 border-b border-cream-200 bg-cream-50/95 backdrop-blur-sm">
        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
          <div class="flex items-center gap-3">
            <button id="menuBtn" aria-label="Open navigation" class="rounded-lg p-2 text-forest-900 hover:bg-cream-200 lg:hidden">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
              <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-ink-600">Municipality of Balingasag · Admin</p>
              <p class="mt-0.5 text-sm text-ink-400">@yield('page-subtitle', 'Admin panel')</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <button aria-label="Notifications" class="relative rounded-full p-2.5 text-forest-900 hover:bg-cream-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
              <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-sage-400 ring-2 ring-cream-50"></span>
            </button>
            <a href="/admin/settings" class="inline-flex items-center justify-center rounded-2xl bg-forest-900 px-4 py-2.5 text-sm font-semibold text-cream-50 shadow-sm hover:bg-forest-700">Site settings</a>
          </div>
        </div>
      </header>
      <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
      </main>
      @yield('modals')
    </div>
  </div>
  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');
    function openSidebar() { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); }
    function closeSidebar() { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }
    menuBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSidebar(); });
  </script>
  @stack('scripts')
</body>
</html>
