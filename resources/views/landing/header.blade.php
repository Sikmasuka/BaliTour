<!-- ==================== HEADER / NAVBAR ==================== -->
<header id="siteNav" class="fixed inset-x-0 top-0 z-40 transition-all duration-300 glass-nav border-b border-[#D4D9CB]/80">
  <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6">
    
    <!-- Brand Logo -->
    <a href="/" class="flex items-center gap-2.5 group" aria-label="Balingasag Tourism">
      <img src="/Logo/BaliTourLogo.png" alt="BaliTour Logo" class="h-8 sm:h-9 w-auto object-contain transition-transform group-hover:scale-105">
      <div class="hidden sm:block border-l border-[#C5CCB8] pl-2.5">
        <p class="text-xs font-bold tracking-tight text-[#0B291E] leading-tight">BALINGASAG</p>
        <p class="text-[9px] uppercase tracking-wider text-[#4A5D4E] font-bold">Misamis Oriental</p>
      </div>
    </a>

    <!-- Quick Nav Links -->
    <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-[#1F3D2B]" aria-label="Main Navigation">
      <a href="#about" class="hover:text-[#0E4E31] transition-colors">About</a>
      <a href="#destinations" class="hover:text-[#0E4E31] transition-colors">Top Spots</a>
      <a href="#experience" class="hover:text-[#0E4E31] transition-colors">Culture & Food</a>
      <a href="#travel-info" class="hover:text-[#0E4E31] transition-colors">Travel Info</a>
    </nav>

    <!-- Actions -->
    <div class="flex items-center gap-2">
      @guest
        <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl border border-[#C5CCB8] bg-[#FAFBF7] px-3.5 py-1.5 text-xs font-bold text-[#0B291E] shadow-2xs hover:bg-white transition-all cursor-pointer">
          <svg class="h-3.5 w-3.5 text-[#144A36]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0 1 12 0v2"/></svg>
          <span>Sign In</span>
        </button>
        <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl bg-[#0B291E] px-3.5 py-1.5 text-xs font-bold text-[#FAFBF7] shadow-sm hover:bg-[#144A36] transition-all cursor-pointer">
          <span>Plan Visit</span>
        </button>
      @endguest
      @auth
        @php
          $portalUrl = auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/user/dashboard');
        @endphp
        <a href="{{ $portalUrl }}" class="inline-flex items-center gap-1.5 rounded-xl bg-[#0B291E] px-3.5 py-1.5 text-xs font-bold text-[#FAFBF7] shadow-sm hover:bg-[#144A36] transition-all">
          <svg class="h-3.5 w-3.5 text-emerald-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
          <span>Dashboard</span>
        </a>
        <button type="button" onclick="if(window.openLogoutModal){ window.openLogoutModal(event); }" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50/70 hover:bg-rose-100/80 px-3 py-1.5 text-xs font-bold text-rose-700 shadow-2xs transition-all cursor-pointer" title="Sign Out">
          <svg class="h-3.5 w-3.5 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          <span class="hidden sm:inline">Sign Out</span>
        </button>
      @endauth
    </div>

  </div>

  <!-- Modern Defined 3px Border Accent Line on Scroll -->
  <div id="navScrollLine" class="absolute bottom-0 inset-x-0 h-[3px] bg-gradient-to-r from-[#0B291E] via-emerald-700 to-[#0B291E] opacity-0 transition-opacity duration-300 pointer-events-none shadow-xs"></div>
  
  <!-- Modern Clear Glowing Scroll Progress Indicator -->
  <div id="navProgressBar" class="absolute bottom-0 left-0 h-[3px] bg-gradient-to-r from-emerald-500 via-emerald-400 to-amber-400 opacity-0 transition-opacity duration-300 pointer-events-none shadow-[0_1px_6px_rgba(16,185,129,0.7)]" style="width: 0%;"></div>
</header>
