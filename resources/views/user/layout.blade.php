<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="BaliTours user dashboard and account pages.">
  <title>{{ $title ?? 'BaliTours User' }}</title>
  <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
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
        },
      },
    }
  </script>
  <style>
    body { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Playfair Display', serif; }
  </style>
</head>
<body class="min-h-screen bg-cream-50 text-ink-900">
  <div class="flex min-h-screen">
    @include('user.sidebar')

    <div id="overlay" class="fixed inset-0 z-30 hidden bg-forest-900/40 lg:hidden"></div>
    <div class="flex min-h-screen w-full flex-col lg:pl-72">
      <header class="sticky top-0 z-20 border-b border-cream-200 bg-cream-50/95 backdrop-blur-sm">
        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
          <div class="flex items-center gap-3">
            <button id="menuBtn" aria-label="Open navigation" class="rounded-lg p-2 text-forest-900 hover:bg-cream-200 lg:hidden">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
              <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-ink-600">BaliTours User</p>
              <p class="mt-0.5 text-sm text-ink-400">@yield('page-subtitle', 'User area')</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <button aria-label="Notifications" class="relative rounded-full p-2.5 text-forest-900 hover:bg-cream-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
              <span class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full bg-sage-400 ring-2 ring-cream-50"></span>
            </button>
            <a href="/user/edit-profile" class="inline-flex items-center justify-center rounded-2xl bg-forest-900 px-4 py-2.5 text-sm font-semibold text-cream-50 shadow-sm hover:bg-forest-700">Account</a>
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
    const sidebar = document.getElementById('userSidebar');
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