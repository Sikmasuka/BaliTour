<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Manage destinations for the Municipality of Balingasag.">
<title>Balingasag Admin · Manage Destinations</title>
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
  a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible { outline: 2px solid #A9C79B; outline-offset: 2px; }
  .panel-enter { transform: translateX(100%); }
  .panel-open { transform: translateX(0); }
  [x-cloak] { display: none !important; }
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

      <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6" aria-label="Admin navigation">
        <p class="px-2 pb-2 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Overview</p>

        <a href="/admin/dashboard" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-cream-100/80 transition hover:bg-white/5 hover:text-cream-50">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
          Dashboard
        </a>

        <p class="px-2 pb-2 pt-5 text-[10px] font-semibold uppercase tracking-[0.24em] text-sage-300/80">Content</p>

        <a href="/admin/destinations" aria-current="page"
          class="group flex items-center gap-3 rounded-xl bg-cream-50 px-3 py-2.5 text-sm font-semibold text-forest-900 shadow-sm">
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

    <div id="overlay" class="fixed inset-0 z-30 hidden bg-forest-900/40 lg:hidden"></div>

    <!-- ===================== MAIN ===================== -->
    <div class="flex min-h-screen w-full flex-col lg:pl-72">

      <header class="sticky top-0 z-20 border-b border-cream-200 bg-cream-50/95 backdrop-blur-sm">
        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
          <div class="flex items-center gap-3">
            <button id="menuBtn" aria-label="Open navigation" class="rounded-lg p-2 text-forest-900 hover:bg-cream-200 lg:hidden">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
              <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-ink-600">Municipality of Balingasag · Admin</p>
              <p class="mt-0.5 text-sm text-ink-400">Manage Destinations</p>
            </div>
          </div>
          <a href="/admin/dashboard" class="hidden items-center gap-1.5 text-sm font-semibold text-forest-900 hover:text-forest-700 sm:inline-flex">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 19l-7-7 7-7M4 12h16"/></svg>
            Back to dashboard
          </a>
        </div>
      </header>

      <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">

        <!-- Page header -->
        <section class="mb-8 flex flex-col gap-4 rounded-3xl bg-forest-900 p-8 sm:flex-row sm:items-center sm:justify-between sm:p-10">
          <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Content</p>
            <h1 class="mt-3 font-serif text-3xl font-medium text-cream-50 sm:text-4xl">Manage Destinations</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-cream-100/80">
              Add the spots visitors see on the public site — photos, video, opening hours, and everything in between.
            </p>
          </div>
          <button id="openAddBtn" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-cream-50 px-5 py-3 text-sm font-semibold text-forest-900 shadow-sm hover:bg-white">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5v14M5 12h14"/></svg>
            Add destination
          </button>
        </section>

        <!-- Stats -->
        <section class="mb-8 grid gap-4 sm:grid-cols-3">
          <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Total</p>
            <p id="statTotal" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
          </article>
          <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Published</p>
            <p id="statPublished" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
          </article>
          <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Drafts</p>
            <p id="statDraft" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
          </article>
        </section>

        <!-- Toolbar -->
        <section class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-cream-200 sm:flex-row sm:items-center sm:justify-between">
          <div class="relative w-full sm:max-w-sm">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <input id="searchInput" type="text" placeholder="Search destinations…"
              class="w-full rounded-2xl border border-cream-200 bg-cream-50 py-2.5 pl-10 pr-4 text-sm text-ink-900 placeholder:text-ink-400 focus:border-forest-700 focus:bg-white">
          </div>
          <div class="flex flex-wrap items-center gap-2">
            <select id="categoryFilter" class="rounded-2xl border border-cream-200 bg-cream-50 px-3.5 py-2.5 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
              <option value="">All categories</option>
              <option value="Nature">Nature</option>
              <option value="Culture">Culture</option>
              <option value="Beach">Beach</option>
              <option value="Adventure">Adventure</option>
              <option value="Heritage">Heritage</option>
              <option value="Food">Food</option>
            </select>
            <select id="statusFilter" class="rounded-2xl border border-cream-200 bg-cream-50 px-3.5 py-2.5 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
              <option value="">All statuses</option>
              <option value="Published">Published</option>
              <option value="Draft">Draft</option>
              <option value="Archived">Archived</option>
            </select>
          </div>
        </section>

        <!-- Grid -->
        <section id="grid" class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3"></section>

        <!-- Empty state -->
        <div id="emptyState" class="hidden flex-col items-center justify-center rounded-3xl border border-dashed border-cream-200 bg-white py-16 text-center">
          <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-cream-100 text-forest-900">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
          </div>
          <p class="mt-4 font-serif text-xl font-medium text-forest-900">No destinations match your search</p>
          <p class="mt-1 text-sm text-ink-600">Try a different keyword or filter, or add a new destination.</p>
        </div>

      </main>
    </div>
  </div>

  <!-- ===================== ADD/EDIT SLIDE-OVER ===================== -->
  <div id="panelOverlay" class="fixed inset-0 z-40 hidden bg-forest-900/40" aria-hidden="true"></div>
  <div id="panel" class="panel-enter fixed inset-y-0 right-0 z-50 flex w-full max-w-xl transform flex-col bg-cream-50 shadow-2xl transition-transform duration-300 ease-out"
    role="dialog" aria-modal="true" aria-labelledby="panelTitle">

    <div class="flex items-center justify-between border-b border-cream-200 bg-white px-6 py-5">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Destination</p>
        <h2 id="panelTitle" class="mt-1 font-serif text-2xl font-medium text-forest-900">Add destination</h2>
      </div>
      <button type="button" id="closePanelBtn" aria-label="Close panel" class="rounded-full p-2 text-ink-600 hover:bg-cream-100">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
    </div>

    <form id="destinationForm" class="flex-1 space-y-7 overflow-y-auto px-6 py-6">

      <!-- Basic info -->
      <div class="space-y-4">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Basic information</p>

        <div>
          <label for="fieldName" class="mb-1.5 block text-sm font-medium text-ink-900">Destination name</label>
          <input id="fieldName" required type="text" placeholder="e.g. Kabatanga Falls"
            class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label for="fieldCategory" class="mb-1.5 block text-sm font-medium text-ink-900">Category</label>
            <select id="fieldCategory" class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700">
              <option>Nature</option>
              <option>Culture</option>
              <option>Beach</option>
              <option>Adventure</option>
              <option>Heritage</option>
              <option>Food</option>
            </select>
          </div>
          <div>
            <label class="mb-1.5 block text-sm font-medium text-ink-900">Status</label>
            <div id="statusGroup" class="flex rounded-xl border border-cream-200 bg-white p-1 text-xs font-semibold">
              <button type="button" data-status="Published" class="status-btn flex-1 rounded-lg px-2 py-1.5 text-ink-600">Published</button>
              <button type="button" data-status="Draft" class="status-btn flex-1 rounded-lg px-2 py-1.5 text-ink-600">Draft</button>
              <button type="button" data-status="Archived" class="status-btn flex-1 rounded-lg px-2 py-1.5 text-ink-600">Archived</button>
            </div>
            <input type="hidden" id="fieldStatus" value="Draft">
          </div>
        </div>

        <div>
          <label for="fieldLocation" class="mb-1.5 block text-sm font-medium text-ink-900">Location / address</label>
          <input id="fieldLocation" type="text" placeholder="e.g. Barangay Kianlagan, Balingasag"
            class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label for="fieldFee" class="mb-1.5 block text-sm font-medium text-ink-900">Entrance fee</label>
            <input id="fieldFee" type="text" placeholder="e.g. ₱20 per person"
              class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700">
          </div>
          <div>
            <label for="fieldHours" class="mb-1.5 block text-sm font-medium text-ink-900">Opening hours</label>
            <input id="fieldHours" type="text" placeholder="e.g. 6:00 AM – 5:00 PM"
              class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700">
          </div>
        </div>
      </div>

      <!-- Description -->
      <div class="space-y-4 border-t border-cream-200 pt-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Description</p>
        <div>
          <div class="mb-1.5 flex items-center justify-between">
            <label for="fieldShort" class="block text-sm font-medium text-ink-900">Short summary</label>
            <span id="shortCount" class="text-xs text-ink-400">0 / 140</span>
          </div>
          <textarea id="fieldShort" maxlength="140" rows="2" placeholder="One or two sentences shown on cards and previews"
            class="w-full resize-none rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700"></textarea>
        </div>
        <div>
          <label for="fieldFull" class="mb-1.5 block text-sm font-medium text-ink-900">Full description</label>
          <textarea id="fieldFull" rows="4" placeholder="Tell visitors what makes this place worth the trip"
            class="w-full resize-none rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700"></textarea>
        </div>
        <div>
          <label class="mb-1.5 block text-sm font-medium text-ink-900">Highlights</label>
          <div id="highlightChips" class="mb-2 flex flex-wrap gap-2"></div>
          <input id="highlightInput" type="text" placeholder="Type a highlight and press Enter — e.g. Waterfall, Swimming, Free parking"
            class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700">
        </div>
      </div>

      <!-- Cover image -->
      <div class="space-y-3 border-t border-cream-200 pt-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Cover image</p>
        <div id="coverDrop" class="relative flex aspect-[16/9] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-cream-200 bg-white text-center transition hover:border-forest-700/40">
          <img id="coverPreview" class="hidden absolute inset-0 h-full w-full object-cover" alt="">
          <div id="coverPlaceholder" class="flex flex-col items-center gap-2 px-4 text-ink-500">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="m4 17 5-5 3.5 3.5L17 11l4 6"/></svg>
            <p class="text-sm font-medium">Click or drag an image here</p>
            <p class="text-xs text-ink-400">JPG or PNG, ideally 1600×900</p>
          </div>
          <button type="button" id="coverRemove" class="absolute right-2.5 top-2.5 hidden rounded-full bg-forest-900/80 p-1.5 text-cream-50 hover:bg-forest-900">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
          </button>
          <input id="coverInput" type="file" accept="image/*" class="hidden">
        </div>
      </div>

      <!-- Gallery -->
      <div class="space-y-3 border-t border-cream-200 pt-6">
        <div class="flex items-center justify-between">
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Photo gallery</p>
          <span id="galleryCount" class="text-xs text-ink-400">0 photos</span>
        </div>
        <div id="galleryGrid" class="grid grid-cols-4 gap-2"></div>
        <button type="button" id="galleryAddBtn" class="flex w-full items-center justify-center gap-2 rounded-xl border-2 border-dashed border-cream-200 bg-white py-3 text-sm font-medium text-ink-600 hover:border-forest-700/40">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
          Add photos
        </button>
        <input id="galleryInput" type="file" accept="image/*" multiple class="hidden">
      </div>

      <!-- Video -->
      <div class="space-y-3 border-t border-cream-200 pt-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Video</p>
        <div id="videoDrop" class="relative flex min-h-[7rem] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-cream-200 bg-white text-center transition hover:border-forest-700/40">
          <video id="videoPreview" class="hidden max-h-56 w-full" controls></video>
          <div id="videoPlaceholder" class="flex flex-col items-center gap-2 px-4 py-6 text-ink-500">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="14" height="14" rx="2"/><path d="m17 9 4-2v10l-4-2"/></svg>
            <p class="text-sm font-medium">Click or drag a video here</p>
            <p class="text-xs text-ink-400">MP4, up to ~200MB — a short walkthrough works great</p>
          </div>
          <button type="button" id="videoRemove" class="absolute right-2.5 top-2.5 hidden rounded-full bg-forest-900/80 p-1.5 text-cream-50 hover:bg-forest-900">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
          </button>
          <input id="videoInput" type="file" accept="video/*" class="hidden">
        </div>
      </div>

      <!-- Featured -->
      <div class="flex items-center justify-between rounded-2xl border border-cream-200 bg-white px-4 py-3.5">
        <div>
          <p class="text-sm font-semibold text-forest-900">Feature on homepage</p>
          <p class="text-xs text-ink-500">Shown in the highlighted section of the public site.</p>
        </div>
        <button type="button" id="featuredToggle" data-on="false" class="relative h-6 w-11 shrink-0 rounded-full bg-cream-200 transition">
          <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
        </button>
      </div>

    </form>

    <div class="flex items-center justify-between gap-3 border-t border-cream-200 bg-white px-6 py-4">
      <button type="button" id="deleteFromPanelBtn" class="hidden text-sm font-semibold text-red-600 hover:text-red-700">Delete destination</button>
      <div class="ml-auto flex items-center gap-3">
        <button type="button" id="cancelBtn" class="rounded-2xl border border-cream-200 bg-white px-5 py-2.5 text-sm font-semibold text-ink-900 hover:bg-cream-100">Cancel</button>
        <button type="submit" form="destinationForm" class="rounded-2xl bg-forest-900 px-5 py-2.5 text-sm font-semibold text-cream-50 shadow-sm hover:bg-forest-700">Save destination</button>
      </div>
    </div>
  </div>

  <!-- ===================== DELETE CONFIRM ===================== -->
  <div id="confirmOverlay" class="fixed inset-0 z-50 hidden items-center justify-center bg-forest-900/50 p-4">
    <div class="w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl">
      <div class="flex h-11 w-11 items-center justify-center rounded-full bg-red-50 text-red-600">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
      </div>
      <h3 class="mt-4 font-serif text-xl font-medium text-forest-900">Delete this destination?</h3>
      <p class="mt-1.5 text-sm text-ink-600">This removes <span id="confirmName" class="font-medium text-forest-900"></span> from the public site. This can't be undone.</p>
      <div class="mt-6 flex justify-end gap-3">
        <button id="confirmCancel" class="rounded-2xl border border-cream-200 bg-white px-4 py-2.5 text-sm font-semibold text-ink-900 hover:bg-cream-100">Cancel</button>
        <button id="confirmDelete" class="rounded-2xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Delete</button>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" class="pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2 translate-y-4 rounded-2xl bg-forest-900 px-5 py-3 text-sm font-medium text-cream-50 opacity-0 shadow-lg transition-all duration-300">
    Destination saved
  </div>

<script>
(function () {
  // ---------- Sidebar (mobile) ----------
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('menuBtn');
  menuBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); });
  overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); });

  // ---------- State ----------
  let destinations = [
    {
      id: crypto.randomUUID(),
      name: 'Kabatanga Falls',
      category: 'Nature',
      status: 'Published',
      location: 'Barangay Kianlagan, Balingasag',
      fee: '₱20 per person',
      hours: '6:00 AM – 5:00 PM',
      short: 'A tiered waterfall tucked in a cool forest ravine, a short trek from the barangay road.',
      full: 'Kabatanga Falls drops in three tiers into a clear catch pool ringed by ferns and hardwood forest. The short trail in is shaded and family-friendly, and the pool at the base is calm enough for a swim most of the year.',
      highlights: ['Waterfall', 'Swimming', 'Short trek'],
      cover: 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=1200&q=80',
      gallery: [
        'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=400&q=80',
        'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400&q=80'
      ],
      video: '',
      featured: true,
    },
    {
      id: crypto.randomUUID(),
      name: 'Macajalar Bay Boardwalk',
      category: 'Beach',
      status: 'Published',
      location: 'Poblacion, Balingasag',
      fee: 'Free',
      hours: 'Open 24 hours',
      short: 'A breezy coastal walk with sunset views over Macajalar Bay.',
      full: 'The boardwalk stretches along the shoreline with benches, food stalls in the evening, and one of the best sunset views in town. Popular with joggers in the early morning and families after dinner.',
      highlights: ['Sunset views', 'Street food', 'Free parking'],
      cover: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80',
      gallery: [],
      video: '',
      featured: false,
    },
    {
      id: crypto.randomUUID(),
      name: 'San Roque Parish Church',
      category: 'Heritage',
      status: 'Draft',
      location: 'Poblacion, Balingasag',
      fee: 'Free',
      hours: '7:00 AM – 6:00 PM',
      short: 'A centuries-old parish church at the heart of town, still in daily use.',
      full: 'One of the oldest structures in Balingasag, the parish church anchors the town plaza and hosts the annual fiesta celebrations. The coral-stone facade and bell tower are well preserved.',
      highlights: ['Historic site', 'Architecture'],
      cover: 'https://images.unsplash.com/photo-1548625149-fc4a29cf7092?w=1200&q=80',
      gallery: [],
      video: '',
      featured: false,
    },
  ];

  const grid = document.getElementById('grid');
  const emptyState = document.getElementById('emptyState');
  const searchInput = document.getElementById('searchInput');
  const categoryFilter = document.getElementById('categoryFilter');
  const statusFilter = document.getElementById('statusFilter');

  const statusStyles = {
    Published: 'bg-sage-300/50 text-forest-800',
    Draft: 'bg-amber-100 text-amber-700',
    Archived: 'bg-cream-200 text-ink-600',
  };

  function updateStats() {
    document.getElementById('statTotal').textContent = destinations.length;
    document.getElementById('statPublished').textContent = destinations.filter(d => d.status === 'Published').length;
    document.getElementById('statDraft').textContent = destinations.filter(d => d.status === 'Draft').length;
  }

  function render() {
    const q = searchInput.value.trim().toLowerCase();
    const cat = categoryFilter.value;
    const stat = statusFilter.value;

    const filtered = destinations.filter(d => {
      const matchesQ = !q || d.name.toLowerCase().includes(q) || d.location.toLowerCase().includes(q);
      const matchesCat = !cat || d.category === cat;
      const matchesStat = !stat || d.status === stat;
      return matchesQ && matchesCat && matchesStat;
    });

    grid.innerHTML = '';
    emptyState.classList.toggle('hidden', filtered.length !== 0);
    emptyState.classList.toggle('flex', filtered.length === 0);

    filtered.forEach(d => {
      const card = document.createElement('article');
      card.className = 'group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200 transition hover:shadow-md';
      card.innerHTML = `
        <div class="relative aspect-[16/10] w-full overflow-hidden bg-cream-100">
          ${d.cover
            ? `<img src="${d.cover}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">`
            : `<div class="flex h-full w-full items-center justify-center text-ink-400">
                 <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="m4 17 5-5 3.5 3.5L17 11l4 6"/></svg>
               </div>`}
          <span class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-[11px] font-semibold ${statusStyles[d.status]}">${d.status}</span>
          ${d.featured ? `<span class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-forest-900/90 px-2.5 py-1 text-[11px] font-semibold text-cream-50">
              <svg class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor"><path d="m12 3 2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.1-5.4 3.1 1.3-6-4.6-4.1 6.1-.6L12 3Z"/></svg>Featured
            </span>` : ''}
          ${d.video ? `<span class="absolute bottom-3 right-3 flex h-7 w-7 items-center justify-center rounded-full bg-forest-900/80 text-cream-50">
              <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </span>` : ''}
        </div>
        <div class="p-5">
          <div class="flex items-start justify-between gap-2">
            <div class="min-w-0">
              <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-ink-500">${d.category}</p>
              <h3 class="mt-1 truncate font-serif text-lg font-medium text-forest-900">${d.name}</h3>
            </div>
          </div>
          <p class="mt-1.5 line-clamp-2 text-sm text-ink-600">${d.short || 'No summary yet.'}</p>
          <div class="mt-3 flex items-center gap-1.5 text-xs text-ink-500">
            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
            <span class="truncate">${d.location || 'No location set'}</span>
          </div>
          <div class="mt-4 flex items-center gap-2 border-t border-cream-100 pt-4">
            <button data-edit="${d.id}" class="flex-1 rounded-xl border border-cream-200 bg-cream-50 px-3 py-2 text-sm font-semibold text-forest-900 hover:bg-cream-100">Edit</button>
            <button data-delete="${d.id}" aria-label="Delete ${d.name}" class="rounded-xl border border-cream-200 bg-cream-50 p-2 text-ink-600 hover:bg-red-50 hover:text-red-600">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2m-8 0v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7"/></svg>
            </button>
          </div>
        </div>`;
      grid.appendChild(card);
    });

    grid.querySelectorAll('[data-edit]').forEach(btn => btn.addEventListener('click', () => openPanel(btn.dataset.edit)));
    grid.querySelectorAll('[data-delete]').forEach(btn => btn.addEventListener('click', () => openConfirm(btn.dataset.delete)));

    updateStats();
  }

  searchInput.addEventListener('input', render);
  categoryFilter.addEventListener('change', render);
  statusFilter.addEventListener('change', render);

  // ---------- Panel (add/edit) ----------
  const panelOverlay = document.getElementById('panelOverlay');
  const panel = document.getElementById('panel');
  const panelTitle = document.getElementById('panelTitle');
  const form = document.getElementById('destinationForm');
  const deleteFromPanelBtn = document.getElementById('deleteFromPanelBtn');

  let editingId = null;
  let coverData = '';
  let galleryData = [];
  let videoData = '';
  let highlights = [];

  function resetForm() {
    form.reset();
    coverData = ''; galleryData = []; videoData = ''; highlights = [];
    document.getElementById('coverPreview').src = '';
    document.getElementById('coverPreview').classList.add('hidden');
    document.getElementById('coverPlaceholder').classList.remove('hidden');
    document.getElementById('coverRemove').classList.add('hidden');
    document.getElementById('videoPreview').src = '';
    document.getElementById('videoPreview').classList.add('hidden');
    document.getElementById('videoPlaceholder').classList.remove('hidden');
    document.getElementById('videoRemove').classList.add('hidden');
    document.getElementById('shortCount').textContent = '0 / 140';
    setStatus('Draft');
    setFeatured(false);
    renderChips();
    renderGallery();
  }

  function openPanel(id) {
    resetForm();
    editingId = id || null;
    if (id) {
      const d = destinations.find(x => x.id === id);
      panelTitle.textContent = 'Edit destination';
      deleteFromPanelBtn.classList.remove('hidden');
      document.getElementById('fieldName').value = d.name;
      document.getElementById('fieldCategory').value = d.category;
      document.getElementById('fieldLocation').value = d.location;
      document.getElementById('fieldFee').value = d.fee;
      document.getElementById('fieldHours').value = d.hours;
      document.getElementById('fieldShort').value = d.short;
      document.getElementById('shortCount').textContent = `${d.short.length} / 140`;
      document.getElementById('fieldFull').value = d.full;
      highlights = [...d.highlights];
      coverData = d.cover;
      galleryData = [...d.gallery];
      videoData = d.video;
      setStatus(d.status);
      setFeatured(d.featured);
      if (coverData) {
        document.getElementById('coverPreview').src = coverData;
        document.getElementById('coverPreview').classList.remove('hidden');
        document.getElementById('coverPlaceholder').classList.add('hidden');
        document.getElementById('coverRemove').classList.remove('hidden');
      }
      if (videoData) {
        document.getElementById('videoPreview').src = videoData;
        document.getElementById('videoPreview').classList.remove('hidden');
        document.getElementById('videoPlaceholder').classList.add('hidden');
        document.getElementById('videoRemove').classList.remove('hidden');
      }
      renderChips();
      renderGallery();
    } else {
      panelTitle.textContent = 'Add destination';
      deleteFromPanelBtn.classList.add('hidden');
    }
    panelOverlay.classList.remove('hidden');
    requestAnimationFrame(() => panel.classList.add('panel-open'));
    document.body.style.overflow = 'hidden';
  }

  function closePanel() {
    panel.classList.remove('panel-open');
    document.body.style.overflow = '';
    setTimeout(() => panelOverlay.classList.add('hidden'), 300);
  }

  document.getElementById('openAddBtn').addEventListener('click', () => openPanel(null));
  document.getElementById('closePanelBtn').addEventListener('click', closePanel);
  document.getElementById('cancelBtn').addEventListener('click', closePanel);
  panelOverlay.addEventListener('click', (e) => { if (e.target === panelOverlay) closePanel(); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closePanel(); closeConfirm(); } });

  // Status segmented control
  function setStatus(value) {
    document.getElementById('fieldStatus').value = value;
    document.querySelectorAll('.status-btn').forEach(btn => {
      const active = btn.dataset.status === value;
      btn.classList.toggle('bg-forest-900', active);
      btn.classList.toggle('text-cream-50', active);
      btn.classList.toggle('text-ink-600', !active);
    });
  }
  document.querySelectorAll('.status-btn').forEach(btn => btn.addEventListener('click', () => setStatus(btn.dataset.status)));

  // Featured toggle
  function setFeatured(on) {
    const toggle = document.getElementById('featuredToggle');
    toggle.dataset.on = on;
    toggle.classList.toggle('bg-forest-900', on);
    toggle.classList.toggle('bg-cream-200', !on);
    toggle.querySelector('span').classList.toggle('translate-x-5', on);
  }
  document.getElementById('featuredToggle').addEventListener('click', function () {
    setFeatured(this.dataset.on !== 'true');
  });

  // Short summary counter
  document.getElementById('fieldShort').addEventListener('input', function () {
    document.getElementById('shortCount').textContent = `${this.value.length} / 140`;
  });

  // Highlights chips
  function renderChips() {
    const wrap = document.getElementById('highlightChips');
    wrap.innerHTML = '';
    highlights.forEach((h, i) => {
      const chip = document.createElement('span');
      chip.className = 'inline-flex items-center gap-1.5 rounded-full bg-sage-300/40 px-3 py-1.5 text-xs font-semibold text-forest-800';
      chip.innerHTML = `${h} <button type="button" aria-label="Remove ${h}" class="text-forest-800/60 hover:text-forest-900">&times;</button>`;
      chip.querySelector('button').addEventListener('click', () => { highlights.splice(i, 1); renderChips(); });
      wrap.appendChild(chip);
    });
  }
  document.getElementById('highlightInput').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const v = this.value.trim();
      if (v) { highlights.push(v); this.value = ''; renderChips(); }
    }
  });

  // Cover image upload
  const coverDrop = document.getElementById('coverDrop');
  const coverInput = document.getElementById('coverInput');
  coverDrop.addEventListener('click', () => coverInput.click());
  coverInput.addEventListener('change', () => handleCoverFile(coverInput.files[0]));
  ['dragover', 'drop'].forEach(evt => coverDrop.addEventListener(evt, e => e.preventDefault()));
  coverDrop.addEventListener('drop', e => handleCoverFile(e.dataTransfer.files[0]));
  function handleCoverFile(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => {
      coverData = reader.result;
      document.getElementById('coverPreview').src = coverData;
      document.getElementById('coverPreview').classList.remove('hidden');
      document.getElementById('coverPlaceholder').classList.add('hidden');
      document.getElementById('coverRemove').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
  document.getElementById('coverRemove').addEventListener('click', (e) => {
    e.stopPropagation();
    coverData = '';
    coverInput.value = '';
    document.getElementById('coverPreview').classList.add('hidden');
    document.getElementById('coverPlaceholder').classList.remove('hidden');
    document.getElementById('coverRemove').classList.add('hidden');
  });

  // Gallery upload
  const galleryInput = document.getElementById('galleryInput');
  document.getElementById('galleryAddBtn').addEventListener('click', () => galleryInput.click());
  galleryInput.addEventListener('change', () => {
    [...galleryInput.files].forEach(file => {
      const reader = new FileReader();
      reader.onload = () => { galleryData.push(reader.result); renderGallery(); };
      reader.readAsDataURL(file);
    });
    galleryInput.value = '';
  });
  function renderGallery() {
    const wrap = document.getElementById('galleryGrid');
    wrap.innerHTML = '';
    galleryData.forEach((src, i) => {
      const cell = document.createElement('div');
      cell.className = 'group relative aspect-square overflow-hidden rounded-lg bg-cream-100';
      cell.innerHTML = `<img src="${src}" class="h-full w-full object-cover" alt="">
        <button type="button" aria-label="Remove photo" class="absolute right-1 top-1 rounded-full bg-forest-900/80 p-1 text-cream-50 opacity-0 transition group-hover:opacity-100">
          <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 6l12 12M18 6 6 18"/></svg>
        </button>`;
      cell.querySelector('button').addEventListener('click', () => { galleryData.splice(i, 1); renderGallery(); });
      wrap.appendChild(cell);
    });
    document.getElementById('galleryCount').textContent = `${galleryData.length} photo${galleryData.length === 1 ? '' : 's'}`;
  }

  // Video upload
  const videoDrop = document.getElementById('videoDrop');
  const videoInput = document.getElementById('videoInput');
  videoDrop.addEventListener('click', () => videoInput.click());
  videoInput.addEventListener('change', () => handleVideoFile(videoInput.files[0]));
  ['dragover', 'drop'].forEach(evt => videoDrop.addEventListener(evt, e => e.preventDefault()));
  videoDrop.addEventListener('drop', e => handleVideoFile(e.dataTransfer.files[0]));
  function handleVideoFile(file) {
    if (!file) return;
    const url = URL.createObjectURL(file);
    videoData = url;
    document.getElementById('videoPreview').src = url;
    document.getElementById('videoPreview').classList.remove('hidden');
    document.getElementById('videoPlaceholder').classList.add('hidden');
    document.getElementById('videoRemove').classList.remove('hidden');
  }
  document.getElementById('videoRemove').addEventListener('click', (e) => {
    e.stopPropagation();
    videoData = '';
    videoInput.value = '';
    document.getElementById('videoPreview').classList.add('hidden');
    document.getElementById('videoPlaceholder').classList.remove('hidden');
    document.getElementById('videoRemove').classList.add('hidden');
  });

  // Submit
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const payload = {
      name: document.getElementById('fieldName').value.trim() || 'Untitled destination',
      category: document.getElementById('fieldCategory').value,
      status: document.getElementById('fieldStatus').value,
      location: document.getElementById('fieldLocation').value.trim(),
      fee: document.getElementById('fieldFee').value.trim(),
      hours: document.getElementById('fieldHours').value.trim(),
      short: document.getElementById('fieldShort').value.trim(),
      full: document.getElementById('fieldFull').value.trim(),
      highlights: [...highlights],
      cover: coverData,
      gallery: [...galleryData],
      video: videoData,
      featured: document.getElementById('featuredToggle').dataset.on === 'true',
    };

    if (editingId) {
      const idx = destinations.findIndex(d => d.id === editingId);
      destinations[idx] = { ...destinations[idx], ...payload };
      showToast('Destination updated');
    } else {
      destinations.unshift({ id: crypto.randomUUID(), ...payload });
      showToast('Destination added');
    }
    render();
    closePanel();
  });

  // ---------- Delete confirm ----------
  const confirmOverlay = document.getElementById('confirmOverlay');
  const confirmName = document.getElementById('confirmName');
  let pendingDeleteId = null;

  function openConfirm(id) {
    pendingDeleteId = id;
    const d = destinations.find(x => x.id === id);
    confirmName.textContent = d ? d.name : 'this destination';
    confirmOverlay.classList.remove('hidden');
    confirmOverlay.classList.add('flex');
  }
  function closeConfirm() {
    confirmOverlay.classList.add('hidden');
    confirmOverlay.classList.remove('flex');
    pendingDeleteId = null;
  }
  document.getElementById('confirmCancel').addEventListener('click', closeConfirm);
  document.getElementById('confirmDelete').addEventListener('click', () => {
    destinations = destinations.filter(d => d.id !== pendingDeleteId);
    showToast('Destination deleted');
    closeConfirm();
    closePanel();
    render();
  });
  deleteFromPanelBtn.addEventListener('click', () => { if (editingId) openConfirm(editingId); });

  // ---------- Toast ----------
  let toastTimer;
  function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    clearTimeout(toastTimer);
    toast.classList.remove('opacity-0', 'translate-y-4');
    toastTimer = setTimeout(() => toast.classList.add('opacity-0', 'translate-y-4'), 2200);
  }

  render();
})();
</script>
</body>
</html>