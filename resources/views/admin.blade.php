<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Municipality of Balingasag admin dashboard.">
<title>Balingasag Admin · Dashboard</title>
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
<style>
  body { font-family: 'Inter', sans-serif; }
  .font-serif { font-family: 'Playfair Display', serif; }
  ::-webkit-scrollbar { width: 8px; height: 8px; }
  ::-webkit-scrollbar-thumb { background: #C4DAB8; border-radius: 999px; }
  ::-webkit-scrollbar-track { background: transparent; }
  a:focus-visible, button:focus-visible { outline: 2px solid #A9C79B; outline-offset: 2px; }
</style>
</head>
<body class="min-h-screen bg-cream-50 text-ink-900">

  <div class="flex min-h-screen">

    <!-- ===================== SIDEBAR ===================== -->
    <aside id="sidebar"
      class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full transform flex-col bg-forest-900 text-cream-100 transition-transform duration-200 lg:translate-x-0">

      <div class="flex items-center px-6 py-6">
        <a href="/" class="block" aria-label="BaliTour Home">
          <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="h-11 w-auto object-contain">
        </a>
      </div>

      <div class="mx-6 h-px bg-white/10"></div>

      <!-- Nav -->
      <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="Admin navigation">
        <p class="px-2 pb-2 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Overview</p>

        <a href="/admin/dashboard" aria-current="page"
          class="group flex items-center gap-3 rounded-xl bg-cream-50 px-3 py-2.5 text-sm font-semibold text-forest-900 shadow-sm">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
          Dashboard
        </a>

        <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Content</p>

        <a href="/admin/destinations" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
          Manage Destinations
        </a>
        <a href="/admin/events" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
          Manage Events
        </a>
        <a href="/admin/reviews" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m12 3 2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.1-5.4 3.1 1.3-6-4.6-4.1 6.1-.6L12 3Z"/></svg>
          Manage Reviews
        </a>

        <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">People</p>

        <a href="/admin/users" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.2"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16.5 5.5a3.2 3.2 0 0 1 0 6.3M21.5 20a5.8 5.8 0 0 0-5-6"/></svg>
          Manage Users
        </a>
        <a href="/admin/bookings" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M9 3v3M15 3v3M8.5 12.5l2.2 2.2L15.5 10"/></svg>
          Manage Bookings
        </a>
        <a href="/admin/messages" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6 8.5 6.5L20.5 6"/></svg>
          Contact Messages
          <span class="ml-auto rounded-full bg-sage-400 px-2 py-0.5 text-[10px] font-semibold text-forest-900">2</span>
        </a>

        <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">System</p>

        <a href="/admin/logs/system" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="m7 9 3 3-3 3M13 15h4"/></svg>
          System Logs
        </a>
        <a href="/admin/logs/security" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 4.5 6v6c0 4.6 3.2 7.9 7.5 9 4.3-1.1 7.5-4.4 7.5-9V6L12 3Z"/><path d="m9.5 12 1.8 1.8L15 10"/></svg>
          Security Logs
        </a>
        <a href="/admin/settings" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 13.5a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V20a2 2 0 1 1-4 0v-.2a1.7 1.7 0 0 0-1.1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H4a2 2 0 1 1 0-4h.2a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H10a1.7 1.7 0 0 0 1-1.6V4a2 2 0 1 1 4 0v.2a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V10a1.7 1.7 0 0 0 1.6 1H20a2 2 0 1 1 0 4h-.2a1.7 1.7 0 0 0-1.6 1Z"/></svg>
          Settings
        </a>
      </nav>

      <!-- Footer: profile -->
      <div class="border-t border-white/10 px-4 py-4">
        <div class="flex items-center gap-3 rounded-xl px-2 py-2 hover:bg-white/5">
          <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sage-400 text-xs font-semibold text-forest-900">MS</div>
          <div class="min-w-0 flex-1">
            <p class="truncate text-sm font-medium text-cream-50">Maria Santos</p>
            <p class="truncate text-xs text-cream-100/60">Administrator</p>
          </div>
          <svg class="h-4 w-4 shrink-0 text-cream-100/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4M16 17l5-5-5-5M21 12H9"/></svg>
        </div>
      </div>
    </aside>

    <!-- Mobile overlay -->
    <div id="overlay" class="fixed inset-0 z-30 hidden bg-forest-900/40 lg:hidden"></div>

    <!-- ===================== MAIN ===================== -->
    <div class="flex min-h-screen w-full flex-col lg:pl-72">

      <!-- Topbar -->
      <header class="sticky top-0 z-20 border-b border-cream-200 bg-cream-50/95 backdrop-blur-sm">
        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
          <div class="flex items-center gap-3">
            <button id="menuBtn" aria-label="Open navigation" class="rounded-lg p-2 text-forest-900 hover:bg-cream-200 lg:hidden">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
              <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-ink-600">Municipality of Balingasag · Admin</p>
              <p class="mt-0.5 text-sm text-ink-400">Tuesday, August 4, 2026</p>
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

        <!-- Hero / welcome -->
        <section class="mb-8 overflow-hidden rounded-3xl bg-forest-900 p-8 shadow-sm sm:p-10">
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Overview</p>
          <h1 class="mt-3 font-serif text-3xl font-medium text-cream-50 sm:text-4xl">
            Good morning, Maria.
          </h1>
          <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">
            Here's what's happening across the site today — new bookings, unread messages, and content that could use your attention.
          </p>
        </section>

        <!-- Stat cards -->
        <section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
            <div class="flex items-center justify-between">
              <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Users</p>
              <span class="rounded-full bg-sage-300/40 px-2 py-1 text-[11px] font-semibold text-forest-800">+4.2%</span>
            </div>
            <p class="mt-4 font-serif text-4xl font-medium text-forest-900">3,910</p>
            <p class="mt-2 text-sm text-ink-600">Active accounts registered with the site.</p>
          </article>
          <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
            <div class="flex items-center justify-between">
              <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Bookings</p>
              <span class="rounded-full bg-sage-300/40 px-2 py-1 text-[11px] font-semibold text-forest-800">+11%</span>
            </div>
            <p class="mt-4 font-serif text-4xl font-medium text-forest-900">1,284</p>
            <p class="mt-2 text-sm text-ink-600">Approved reservations this month.</p>
          </article>
          <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
            <div class="flex items-center justify-between">
              <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Pending review</p>
              <span class="rounded-full bg-amber-100 px-2 py-1 text-[11px] font-semibold text-amber-700">Needs action</span>
            </div>
            <p class="mt-4 font-serif text-4xl font-medium text-forest-900">15</p>
            <p class="mt-2 text-sm text-ink-600">Items waiting for approval.</p>
          </article>
        </section>

        <!-- Quick actions + activity -->
        <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">

          <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
            <div class="flex items-center justify-between gap-4">
              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Quick actions</p>
                <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">Manage core content</h2>
              </div>
              <span class="hidden rounded-full bg-cream-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-ink-600 sm:inline-flex">Admin</span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
              <a href="/admin/destinations" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
                  <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
                </div>
                <p class="mt-3 text-base font-semibold text-forest-900">Destinations</p>
                <p class="mt-1 text-sm text-ink-600">Edit the places shown on the public site.</p>
              </a>
              <a href="/admin/events" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
                  <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                </div>
                <p class="mt-3 text-base font-semibold text-forest-900">Events</p>
                <p class="mt-1 text-sm text-ink-600">Publish upcoming festivals and tours.</p>
              </a>
              <a href="/admin/users" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
                  <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.2"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/></svg>
                </div>
                <p class="mt-3 text-base font-semibold text-forest-900">Users</p>
                <p class="mt-1 text-sm text-ink-600">Review account roles and activity.</p>
              </a>
              <a href="/admin/bookings" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
                  <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M9 3v3M15 3v3M8.5 12.5l2.2 2.2L15.5 10"/></svg>
                </div>
                <p class="mt-3 text-base font-semibold text-forest-900">Bookings</p>
                <p class="mt-1 text-sm text-ink-600">Manage reservation status and requests.</p>
              </a>
            </div>
          </div>

          <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Recent activity</p>
            <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">What needs attention</h2>
            <ul class="mt-6 space-y-3">
              <li class="flex items-start gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
                <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-amber-500"></span>
                <p class="text-sm text-ink-600"><span class="font-semibold text-forest-900">5 new bookings</span> are pending approval.</p>
              </li>
              <li class="flex items-start gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
                <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-sage-400"></span>
                <p class="text-sm text-ink-600"><span class="font-semibold text-forest-900">4 destination listings</span> need updated photos.</p>
              </li>
              <li class="flex items-start gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
                <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-forest-800"></span>
                <p class="text-sm text-ink-600"><span class="font-semibold text-forest-900">2 unread messages</span> in the contact inbox.</p>
              </li>
            </ul>
            <a href="/admin/messages" class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-forest-900 hover:text-forest-700">
              Go to inbox
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </div>
        </section>

        <!-- Recent signups -->
        <section class="mt-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
          <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
              <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">User snapshot</p>
              <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">Recent signups</h2>
            </div>
            <a href="/admin/users" class="inline-flex items-center gap-1.5 text-sm font-semibold text-forest-900 hover:text-forest-700">
              View all users
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </div>

          <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-cream-200 text-left text-sm">
              <thead class="bg-cream-50 text-ink-600">
                <tr>
                  <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">User</th>
                  <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">Email</th>
                  <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">Role</th>
                  <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-cream-200">
                <tr>
                  <td class="whitespace-nowrap px-4 py-4 font-medium text-forest-900">Maria Santos</td>
                  <td class="whitespace-nowrap px-4 py-4 text-ink-600">maria.santos@balingasag.gov.ph</td>
                  <td class="whitespace-nowrap px-4 py-4"><span class="rounded-full bg-forest-900/10 px-2.5 py-1 text-xs font-semibold text-forest-900">Admin</span></td>
                  <td class="whitespace-nowrap px-4 py-4"><span class="inline-flex items-center gap-1.5 text-ink-600"><span class="h-1.5 w-1.5 rounded-full bg-sage-400"></span>Active</span></td>
                </tr>
                <tr>
                  <td class="whitespace-nowrap px-4 py-4 font-medium text-forest-900">Jomar Villanueva</td>
                  <td class="whitespace-nowrap px-4 py-4 text-ink-600">jomar.v@gmail.com</td>
                  <td class="whitespace-nowrap px-4 py-4"><span class="rounded-full bg-cream-200 px-2.5 py-1 text-xs font-semibold text-ink-600">Staff</span></td>
                  <td class="whitespace-nowrap px-4 py-4"><span class="inline-flex items-center gap-1.5 text-ink-600"><span class="h-1.5 w-1.5 rounded-full bg-sage-400"></span>Active</span></td>
                </tr>
                <tr>
                  <td class="whitespace-nowrap px-4 py-4 font-medium text-forest-900">Ana Reyes</td>
                  <td class="whitespace-nowrap px-4 py-4 text-ink-600">ana.reyes@gmail.com</td>
                  <td class="whitespace-nowrap px-4 py-4"><span class="rounded-full bg-cream-200 px-2.5 py-1 text-xs font-semibold text-ink-600">Visitor</span></td>
                  <td class="whitespace-nowrap px-4 py-4"><span class="inline-flex items-center gap-1.5 text-ink-600"><span class="h-1.5 w-1.5 rounded-full bg-sage-400"></span>Active</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

      </main>

      <footer class="px-4 py-6 text-center text-xs text-ink-400 sm:px-6 lg:px-8">
        Municipality of Balingasag · Misamis Oriental · Admin Panel
      </footer>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');

    function openSidebar() {
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
    }
    function closeSidebar() {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    }
    menuBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSidebar(); });
  </script>
</body>
</html>