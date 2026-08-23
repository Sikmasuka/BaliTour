<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Discover Balingasag, Misamis Oriental — Explore Cameo Island, Kabatanga Falls, San Roque Church, and famous Balingasag Bibingka.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Balingasag Tourism · Misamis Oriental</title>
  
  <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <style>
    :root {
      --bg-offwhite: #F3F4EE;
      --bg-offwhite-alt: #EAECE2;
      --forest-dark: #061A13;
      --forest-main: #0B291E;
      --border-tint: #D4D9CB;
    }
    body {
      font-family: 'Inter', sans-serif;
      color: #0F172A;
      background-color: var(--bg-offwhite);
      overflow-x: hidden;
    }
    .font-serif {
      font-family: 'Playfair Display', serif;
    }
    .glass-nav {
      background: rgba(243, 244, 238, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
    }
    .hero-overlay {
      background: linear-gradient(180deg, rgba(6,26,19,0.85) 0%, rgba(6,26,19,0.52) 50%, rgba(6,26,19,0.92) 100%);
    }
    .card-offwhite {
      background: #FAFBF7;
      border: 1px solid var(--border-tint);
    }
    
    /* Modern Scroll Reveal Transitions */
    .reveal-on-scroll {
      opacity: 0;
      transform: translateY(28px);
      transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
      will-change: opacity, transform;
    }
    .reveal-on-scroll.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
    .delay-100 { transition-delay: 80ms; }
    .delay-200 { transition-delay: 160ms; }
    .delay-300 { transition-delay: 240ms; }
    .delay-400 { transition-delay: 320ms; }
  </style>
</head>
<body class="min-h-screen text-slate-900 antialiased selection:bg-emerald-800 selection:text-white bg-[#F3F4EE]">

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

  <main id="main-content" class="pt-[54px]">

    <!-- ==================== HERO SECTION (HIGH IMPACT ILLUMINATED FOREST) ==================== -->
    <section class="relative min-h-[78vh] flex items-center justify-center overflow-hidden bg-[#061A13] text-white px-4 py-20 sm:px-6">
      
      <!-- Cinematic Video Background -->
      <video autoplay muted loop playsinline class="absolute inset-0 h-full w-full object-cover opacity-50" poster="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1400&q=80">
        <source src="/hero-video.mp4" type="video/mp4">
      </video>

      <!-- Deep Emerald Vignette Overlay -->
      <div class="absolute inset-0 hero-overlay"></div>

      <!-- Modern Ambient Radial Glow Light -->
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[360px] bg-emerald-500/15 blur-[130px] pointer-events-none rounded-full z-0"></div>

      <!-- Hero Main Content -->
      <div class="relative z-10 mx-auto max-w-4xl text-center flex flex-col items-center">
        
        <!-- Eyebrow Tag -->
        <div class="inline-flex items-center gap-2.5 rounded-full border border-emerald-400/30 bg-[#0B291E]/90 px-4 py-1.5 text-[11px] font-bold tracking-widest text-emerald-300 backdrop-blur-md mb-6 shadow-lg shadow-black/40 ring-1 ring-emerald-400/20">
          <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
          </span>
          <span>MUNICIPALITY OF BALINGASAG · MISAMIS ORIENTAL</span>
        </div>

        <!-- Grand Headline with Clear Sharp Accent -->
        <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-normal tracking-tight text-white leading-[1.12]">
          Welcome to Balingasag<br>
          <span class="font-serif italic font-normal text-emerald-400">
            Where the Sea, Stories, and Culture Meet.
          </span>
        </h1>

        <!-- Subtitle -->
        <p class="mt-5 max-w-2xl text-sm sm:text-base text-[#E2E8DF]/95 leading-relaxed font-normal">
          Experience the coastal charm of Balingasag, Misamis Oriental — a town shaped by beautiful landscapes, enduring heritage, vibrant traditions, and the warmth of its people.
        </p>

        <!-- Modern Action Buttons -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3.5">
          <a href="#destinations" class="group inline-flex items-center gap-2.5 rounded-xl bg-gradient-to-r from-[#144A36] to-[#1A5C43] hover:from-[#1A5C43] hover:to-[#1E7E52] border border-emerald-400/40 px-6 py-3.5 text-xs font-bold text-white shadow-xl shadow-emerald-950/60 transition-all duration-300 transform hover:-translate-y-0.5">
            <span>Explore Destinations</span>
            <svg class="h-4 w-4 text-emerald-300 transition-transform duration-300 group-hover:translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
          </a>
          
          <button type="button" class="open-modal group inline-flex items-center gap-2.5 rounded-xl border border-white/30 bg-white/10 hover:bg-white/20 hover:border-white/50 px-6 py-3.5 text-xs font-bold text-white backdrop-blur-md transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer shadow-lg">
            <span>Plan Your Visit</span>
            <svg class="h-4 w-4 text-slate-300 transition-transform duration-300 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </button>
        </div>

        <!-- Modern Scroll Anchor Prompt -->
        <a href="#about" class="mt-12 group inline-flex flex-col items-center gap-1.5 text-[10px] font-bold tracking-widest text-[#A2B3A6] hover:text-emerald-300 uppercase transition-colors" aria-label="Scroll down to explore">
          <span>Scroll to explore</span>
          <svg class="h-4 w-4 text-emerald-400 animate-bounce transition-transform group-hover:translate-y-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </a>

      </div>
    </section>

    <!-- ==================== ABOUT BALINGASAG (WARM OFF-WHITE SECTION) ==================== -->
    <section id="about" class="py-12 bg-[#FAFBF7] border-b border-[#D4D9CB] overflow-hidden">
      <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
          
          <div class="md:col-span-7 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-1.5 rounded-lg bg-[#E8F5E9] border border-[#C8E6C9] px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-[#0E4E31]">
              About Balingasag
            </div>
            <h2 class="font-serif text-2xl sm:text-3xl font-medium text-[#0B291E]">
              An Authentic Coastal & Upland Haven
            </h2>
            <p class="text-xs sm:text-sm text-[#334155] leading-relaxed">
              Balingasag is a historic first-class municipality in <strong>Misamis Oriental, Northern Mindanao</strong>. Flanked by the calm waters of Macajalar Bay and the emerald ridges of Mount Balatukan, it connects travelers to rich heritage, refreshing eco-adventures, and genuine hospitality.
            </p>
            <div class="grid grid-cols-2 gap-3 pt-2 text-xs font-bold text-[#1F3D2B]">
              <div class="flex items-center gap-2 rounded-xl bg-[#F3F4EE] p-2.5 border border-[#D4D9CB]">
                <svg class="h-4 w-4 shrink-0 text-[#0E4E31]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Protected Island & Coral Reefs</span>
              </div>
              <div class="flex items-center gap-2 rounded-xl bg-[#F3F4EE] p-2.5 border border-[#D4D9CB]">
                <svg class="h-4 w-4 shrink-0 text-[#0E4E31]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Century-Old Spanish Church</span>
              </div>
              <div class="flex items-center gap-2 rounded-xl bg-[#F3F4EE] p-2.5 border border-[#D4D9CB]">
                <svg class="h-4 w-4 shrink-0 text-[#0E4E31]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Upland Waterfalls & Springs</span>
              </div>
              <div class="flex items-center gap-2 rounded-xl bg-[#F3F4EE] p-2.5 border border-[#D4D9CB]">
                <svg class="h-4 w-4 shrink-0 text-[#0E4E31]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Famous Balingasag Bibingka</span>
              </div>
            </div>
          </div>

          <div class="md:col-span-5 relative reveal-on-scroll delay-200">
            <div class="overflow-hidden rounded-2xl border border-[#D4D9CB] shadow-md aspect-[4/3] group">
              <img src="https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=800&q=80" alt="Balingasag Heritage" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ==================== KEY DESTINATIONS (CONTRAST OFF-WHITE SECTION) ==================== -->
    <section id="destinations" class="py-12 bg-[#F3F4EE] overflow-hidden">
      <div class="mx-auto max-w-6xl px-4 sm:px-6">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8 reveal-on-scroll">
          <div>
            <div class="inline-flex items-center gap-1.5 rounded-lg bg-[#E8F5E9] border border-[#C8E6C9] px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-[#0E4E31] mb-1.5">
              Destinations
            </div>
            <h2 class="font-serif text-2xl sm:text-3xl font-medium text-[#0B291E]">
              Top Places to Visit in Balingasag
            </h2>
          </div>
          <p class="text-xs text-[#4A5D4E] font-medium max-w-xs">
            Authentic landmarks and attractions across the coast, town center, and mountains.
          </p>
        </div>

        <!-- Clean 4-Card Grid with Staggered Entrance -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          
          <!-- Spot 1: Cameo Island -->
          <div class="group flex flex-col rounded-2xl card-offwhite shadow-sm hover:shadow-xl hover:border-[#144A36] transition-all duration-300 overflow-hidden reveal-on-scroll delay-100">
            <div class="relative aspect-[16/10] overflow-hidden bg-[#E7EAE0]">
              <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="Cameo Island Balingasag" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
              <span class="absolute top-2 left-2 rounded-md bg-[#0B291E]/90 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-emerald-300">Island & Snorkel</span>
              <span class="absolute top-2 right-2 flex items-center gap-1 rounded-md bg-[#FAFBF7]/95 px-1.5 py-0.5 text-[10px] font-bold text-[#0B291E]">
                <svg class="h-3 w-3 text-amber-500 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span>4.9</span>
              </span>
            </div>
            <div class="p-3.5 flex-1 flex flex-col">
              <p class="text-[10px] font-bold text-[#144A36] uppercase">Macajalar Bay</p>
              <h3 class="font-serif text-sm font-bold text-[#0B291E] mt-0.5">Cameo (Mantalingo) Island</h3>
              <p class="text-xs text-[#334155] mt-1 leading-relaxed">Pristine coral islet sanctuary with crystal turquoise waters ideal for boat tours, diving, and snorkeling.</p>
              <div class="mt-auto pt-2.5 border-t border-[#D4D9CB] flex items-center justify-between text-[11px]">
                <span class="font-medium text-[#475569]">Boat Tour</span>
                <span class="font-bold text-[#0E4E31]">Must Visit</span>
              </div>
            </div>
          </div>

          <!-- Spot 2: Kabatanga Falls -->
          <div class="group flex flex-col rounded-2xl card-offwhite shadow-sm hover:shadow-xl hover:border-[#144A36] transition-all duration-300 overflow-hidden reveal-on-scroll delay-200">
            <div class="relative aspect-[16/10] overflow-hidden bg-[#E7EAE0]">
              <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=600&q=80" alt="Kabatanga Falls" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
              <span class="absolute top-2 left-2 rounded-md bg-[#0B291E]/90 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-emerald-300">Waterfalls</span>
              <span class="absolute top-2 right-2 flex items-center gap-1 rounded-md bg-[#FAFBF7]/95 px-1.5 py-0.5 text-[10px] font-bold text-[#0B291E]">
                <svg class="h-3 w-3 text-amber-500 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span>4.9</span>
              </span>
            </div>
            <div class="p-3.5 flex-1 flex flex-col">
              <p class="text-[10px] font-bold text-[#144A36] uppercase">Brgy. Waterfall</p>
              <h3 class="font-serif text-sm font-bold text-[#0B291E] mt-0.5">Kabatanga Falls</h3>
              <p class="text-xs text-[#334155] mt-1 leading-relaxed">A refreshing cascading waterfall with cool natural swimming basins and shaded forest picnic spots.</p>
              <div class="mt-auto pt-2.5 border-t border-[#D4D9CB] flex items-center justify-between text-[11px]">
                <span class="font-medium text-[#475569]">Fee: ₱30</span>
                <span class="font-bold text-[#0E4E31]">Open Daily</span>
              </div>
            </div>
          </div>

          <!-- Spot 3: San Roque Parish Church & Vega House -->
          <div class="group flex flex-col rounded-2xl card-offwhite shadow-sm hover:shadow-xl hover:border-[#144A36] transition-all duration-300 overflow-hidden reveal-on-scroll delay-300">
            <div class="relative aspect-[16/10] overflow-hidden bg-[#E7EAE0]">
              <img src="https://images.unsplash.com/photo-1548625361-195fe579b5c3?auto=format&fit=crop&w=600&q=80" alt="San Roque Church Balingasag" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
              <span class="absolute top-2 left-2 rounded-md bg-[#0B291E]/90 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-amber-300">Heritage</span>
              <span class="absolute top-2 right-2 flex items-center gap-1 rounded-md bg-[#FAFBF7]/95 px-1.5 py-0.5 text-[10px] font-bold text-[#0B291E]">
                <svg class="h-3 w-3 text-amber-500 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span>4.8</span>
              </span>
            </div>
            <div class="p-3.5 flex-1 flex flex-col">
              <p class="text-[10px] font-bold text-[#B45309] uppercase">Poblacion</p>
              <h3 class="font-serif text-sm font-bold text-[#0B291E] mt-0.5">San Roque Church & Vega House</h3>
              <p class="text-xs text-[#334155] mt-1 leading-relaxed">Historic 19th-century Spanish stone church and preserved century-old wooden ancestral house.</p>
              <div class="mt-auto pt-2.5 border-t border-[#D4D9CB] flex items-center justify-between text-[11px]">
                <span class="font-medium text-[#475569]">Poblacion Center</span>
                <span class="font-bold text-[#0E4E31]">Free Access</span>
              </div>
            </div>
          </div>

          <!-- Spot 4: Balingasag Baywalk & Bibingka Lane -->
          <div class="group flex flex-col rounded-2xl card-offwhite shadow-sm hover:shadow-xl hover:border-[#144A36] transition-all duration-300 overflow-hidden reveal-on-scroll delay-400">
            <div class="relative aspect-[16/10] overflow-hidden bg-[#E7EAE0]">
              <img src="https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=600&q=80" alt="Balingasag Baywalk" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
              <span class="absolute top-2 left-2 rounded-md bg-[#0B291E]/90 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-rose-300">Sunset & Food</span>
              <span class="absolute top-2 right-2 flex items-center gap-1 rounded-md bg-[#FAFBF7]/95 px-1.5 py-0.5 text-[10px] font-bold text-[#0B291E]">
                <svg class="h-3 w-3 text-amber-500 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span>4.8</span>
              </span>
            </div>
            <div class="p-3.5 flex-1 flex flex-col">
              <p class="text-[10px] font-bold text-[#9F1239] uppercase">Brgy. Hermano</p>
              <h3 class="font-serif text-sm font-bold text-[#0B291E] mt-0.5">Balingasag Baywalk Boulevard</h3>
              <p class="text-xs text-[#334155] mt-1 leading-relaxed">Scenic sunset stroll along Macajalar Bay with fresh seafood grills, barbecue, and hot native bibingka.</p>
              <div class="mt-auto pt-2.5 border-t border-[#D4D9CB] flex items-center justify-between text-[11px]">
                <span class="font-medium text-[#475569]">Night Stalls (4PM)</span>
                <span class="font-bold text-[#0E4E31]">Free Entry</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- ==================== CULTURE & LOCAL FLAVORS (RICH EMERALD & OFF-WHITE SPLIT) ==================== -->
    <section id="experience" class="py-12 bg-[#FAFBF7] border-b border-[#D4D9CB] overflow-hidden">
      <div class="mx-auto max-w-6xl px-4 sm:px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
          
          <!-- Bibingka & Food Card -->
          <div class="rounded-2xl border border-[#D4D9CB] bg-[#F3F4EE] p-6 space-y-3 flex flex-col justify-between reveal-on-scroll delay-100 hover:shadow-lg transition-all duration-300">
            <div>
              <div class="flex items-center gap-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-100 text-amber-800">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#B45309]">Local Culinary Pride</p>
              </div>
              <h3 class="font-serif text-xl font-bold text-[#0B291E] mt-1">Famous Balingasag Bibingka</h3>
              <p class="text-xs text-[#334155] mt-2 leading-relaxed">
                No trip to Misamis Oriental is complete without tasting the iconic <strong>Bibingka sa Balingasag</strong>. Freshly baked over clay stoves with young coconut strips, butter, and cheese — available fresh daily at the public market and highway bus stops.
              </p>
            </div>
            <div class="pt-3 border-t border-[#D4D9CB] flex items-center justify-between text-xs font-bold text-[#0B291E]">
              <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>₱20–₱100 / box</span>
              </span>
              <span class="flex items-center gap-1.5 text-slate-700">
                <svg class="h-3.5 w-3.5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>Market & Terminal</span>
              </span>
            </div>
          </div>

          <!-- San Roque Fiesta Card (Deep Forest Contrast) -->
          <div class="rounded-2xl bg-[#0B291E] text-white p-6 space-y-3 flex flex-col justify-between border border-[#144A36] shadow-md reveal-on-scroll delay-200 hover:shadow-xl transition-all duration-300">
            <div>
              <div class="flex items-center gap-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-900 text-emerald-300 border border-emerald-700/50">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20a2.4 2.4 0 0 0 2 1 2.4 2.4 0 0 0 2-1 2.4 2.4 0 0 1 2-1 2.4 2.4 0 0 1 2 1 2.4 2.4 0 0 0 2 1 2.4 2.4 0 0 0 2-1 2.4 2.4 0 0 1 2-1 2.4 2.4 0 0 1 2 1 2.4 2.4 0 0 0 2 1 2.4 2.4 0 0 0 2-1"></path><path d="M4 18 3 13h18l-1 5"></path><path d="M12 2v11"></path><path d="m9 5 3-3 3 3"></path></svg>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-300">Grand Celebration</p>
              </div>
              <h3 class="font-serif text-xl font-bold text-white mt-1">San Roque Fiesta & Fluvial Parade</h3>
              <p class="text-xs text-[#E2E8DF] mt-2 leading-relaxed">
                Held every <strong>August 16</strong>, the town honors patron saint San Roque with a vibrant maritime fluvial procession along Macajalar Bay, traditional street dancing, and community thanksgiving banquets.
              </p>
            </div>
            <div class="pt-3 border-t border-white/15 flex items-center justify-between text-xs font-bold text-emerald-300">
              <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>August 16 Annually</span>
              </span>
              <span class="flex items-center gap-1.5 text-slate-300">
                <svg class="h-3.5 w-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>Macajalar Bayfront</span>
              </span>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- ==================== TRAVEL INFO & SAFETY (DEEP CONTRAST WITH OFF-WHITE) ==================== -->
    <section id="travel-info" class="py-12 bg-[#F3F4EE] overflow-hidden">
      <div class="mx-auto max-w-6xl px-4 sm:px-6">
        
        <div class="text-center max-w-xl mx-auto mb-8 reveal-on-scroll">
          <div class="inline-flex items-center gap-1.5 rounded-lg bg-[#E8F5E9] border border-[#C8E6C9] px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-[#0E4E31] mb-1.5">
            Travel Guide
          </div>
          <h2 class="font-serif text-2xl font-medium text-[#0B291E]">
            How to Get to Balingasag
          </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
          
          <div class="rounded-2xl card-offwhite p-4 shadow-2xs reveal-on-scroll delay-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-2 mb-1">
              <svg class="h-4 w-4 text-[#144A36]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="14" rx="2"></rect><path d="M7 21h10"></path><path d="M12 17v4"></path></svg>
              <p class="text-[10px] font-bold uppercase text-[#475569]">From CDO Agora Terminal</p>
            </div>
            <h4 class="font-serif text-sm font-bold text-[#0B291E] mt-1">Bus or UV Express Van</h4>
            <p class="text-xs text-[#334155] mt-1.5 leading-relaxed">Take any Gingoog/Balingasag bound bus (Rural Transit) or UV van. Travel time: ~45–60 mins (₱70–₱120).</p>
          </div>

          <div class="rounded-2xl card-offwhite p-4 shadow-2xs reveal-on-scroll delay-200 hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-2 mb-1">
              <svg class="h-4 w-4 text-[#144A36]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"></path><path d="m22 2-7 20-4-9-9-4 20-7z"></path></svg>
              <p class="text-[10px] font-bold uppercase text-[#475569]">From Laguindingan Airport</p>
            </div>
            <h4 class="font-serif text-sm font-bold text-[#0B291E] mt-1">Airport Shuttle + Bus</h4>
            <p class="text-xs text-[#334155] mt-1.5 leading-relaxed">Airport shuttle to Agora Terminal CDO, then transfer to a Balingasag direct bus (~1 hr 15 mins total).</p>
          </div>

          <div class="rounded-2xl card-offwhite p-4 shadow-2xs reveal-on-scroll delay-300 hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-2 mb-1">
              <svg class="h-4 w-4 text-[#144A36]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              <p class="text-[10px] font-bold uppercase text-[#475569]">Getting Around Town</p>
            </div>
            <h4 class="font-serif text-sm font-bold text-[#0B291E] mt-1">Tricycle & Habal-Habal</h4>
            <p class="text-xs text-[#334155] mt-1.5 leading-relaxed">Tricycles for Poblacion & Baywalk (₱15–₱25). Habal-habal motorcycle for upland Kabatanga Falls (₱50–₱100).</p>
          </div>

        </div>

        <!-- 24/7 Hotline Bar (Deep Forest) -->
        <div class="rounded-2xl bg-[#0B291E] text-white p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl border border-[#144A36] reveal-on-scroll delay-100">
          <div>
            <div class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-emerald-300">
              <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
              Balingasag Tourist Assistance & Safety
            </div>
            <h3 class="font-serif text-lg font-bold text-white mt-1">Need help or tour guidance?</h3>
            <p class="text-xs text-[#E2E8DF]">Municipal Tourism Desk: (088) 333-2100 · MDRRMO Rescue 911 Hotline: 0917-888-2254</p>
          </div>
          <button type="button" class="open-modal shrink-0 rounded-xl bg-[#144A36] hover:bg-[#1E7E52] border border-emerald-500/40 px-4 py-2.5 text-xs font-bold text-white shadow transition-all cursor-pointer">
            Contact / Plan Tour
          </button>
        </div>

      </div>
    </section>

  </main>

  <!-- ==================== PROFESSIONAL MODERN FOOTER (DEEP FOREST CONTRAST) ==================== -->
  <footer class="bg-[#061A13] text-[#A2B3A6] pt-14 pb-8 border-t border-[#0F3B2B] relative overflow-hidden">
    
    <!-- Subtle Ambient Top Glow -->
    <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-emerald-500/30 to-transparent"></div>

    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      
      <!-- Main Footer Grid (4 Columns) -->
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-12 border-b border-[#0F3B2B]">
        
        <!-- Column 1: Municipal Brand & Mission (md:col-span-4) -->
        <div class="md:col-span-4 space-y-3.5">
          <a href="/" class="flex items-center gap-2.5 group" aria-label="Balingasag Tourism Home">
            <img src="/Logo/BaliTourLogo.png" alt="BaliTour Logo" class="h-9 w-auto object-contain transition-transform group-hover:scale-105">
            <div class="border-l border-[#1F4D3B] pl-2.5">
              <p class="text-xs font-bold tracking-tight text-white leading-tight">BALINGASAG</p>
              <p class="text-[9px] uppercase tracking-wider text-emerald-400 font-bold">Misamis Oriental</p>
            </div>
          </a>
          
          <p class="text-xs text-[#8E9F92] leading-relaxed pr-2">
            The official tourism portal for the <strong>Municipality of Balingasag</strong>. Dedicated to showcasing our protected marine sanctuaries, mountain waterfalls, Spanish colonial heritage, and warm Misamisnon culture.
          </p>

          <div class="pt-1 flex items-center gap-2 text-[11px] text-emerald-400 font-bold">
            <svg class="h-3.5 w-3.5 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Municipal Hall, Poblacion, Balingasag 9005</span>
          </div>
        </div>

        <!-- Column 2: Key Destinations (md:col-span-2) -->
        <div class="md:col-span-2 space-y-3">
          <p class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
            Top Spots
          </p>
          <ul class="space-y-2 text-xs text-[#A2B3A6]">
            <li><a href="#destinations" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Cameo Island</a></li>
            <li><a href="#destinations" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Kabatanga Falls</a></li>
            <li><a href="#destinations" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">San Roque Parish</a></li>
            <li><a href="#destinations" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Vega Ancestral House</a></li>
            <li><a href="#destinations" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Balingasag Baywalk</a></li>
          </ul>
        </div>

        <!-- Column 3: Culture & Visitor Links (md:col-span-3) -->
        <div class="md:col-span-3 space-y-3">
          <p class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
            Visitor Guide
          </p>
          <ul class="space-y-2 text-xs text-[#A2B3A6]">
            <li><a href="#about" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">About Balingasag</a></li>
            <li><a href="#experience" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">San Roque Fiesta (Aug 16)</a></li>
            <li><a href="#experience" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Famous Native Bibingka</a></li>
            <li><a href="#travel-info" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Transport from CDO / Airport</a></li>
            <li><a href="#travel-info" class="hover:text-emerald-300 hover:translate-x-0.5 transition-all inline-block">Local Tricycle & Fares</a></li>
          </ul>
        </div>

        <!-- Column 4: Official Contact & Quick Action (md:col-span-3) -->
        <div class="md:col-span-3 space-y-3">
          <p class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
            Tourism Assistance
          </p>
          
          <div class="rounded-xl bg-[#0B291E] border border-[#144A36] p-3 space-y-2 text-xs text-[#E2E8DF]">
            <p class="text-[10px] font-bold uppercase text-emerald-400">Municipal Tourism Office</p>
            <p class="font-semibold text-white flex items-center gap-2">
              <svg class="h-3.5 w-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              <span>(088) 333-2100</span>
            </p>
            <p class="text-[11px] text-[#A2B3A6] flex items-center gap-2">
              <svg class="h-3.5 w-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              <span>tourism@balingasag.gov.ph</span>
            </p>
            <p class="text-[10px] text-[#718576] pt-1">Mon–Fri: 8:00 AM – 5:00 PM</p>
          </div>

          <div class="pt-1">
            <button type="button" class="open-modal w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#144A36] hover:bg-[#1E7E52] border border-emerald-500/30 px-3 py-2 text-xs font-bold text-white shadow transition-all cursor-pointer">
              <span>Sign In / Register</span>
              <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0 1 12 0v2"/></svg>
            </button>
          </div>
        </div>

      </div>

      <!-- Bottom Bar (Legal, Accreditation & Copyright) -->
      <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-[#718576]">
        <div class="flex flex-wrap items-center gap-3 text-[11px]">
          <span>© {{ date('Y') }} Municipality of Balingasag.</span>
          <span>·</span>
          <span>Province of Misamis Oriental</span>
          <span>·</span>
          <span class="text-[#A2B3A6] font-medium">BaliTour Information System</span>
        </div>

        <div class="flex items-center gap-4 text-[11px]">
          <a href="#" class="hover:text-[#A2B3A6] transition-colors">Privacy Policy</a>
          <span>·</span>
          <a href="#" class="hover:text-[#A2B3A6] transition-colors">Terms of Service</a>
          <span>·</span>
          <a href="#main-content" class="hover:text-emerald-400 transition-colors">Back to Top ↑</a>
        </div>
      </div>

    </div>
  </footer>

  <!-- Include Existing Login/Register Auth Modal -->
  @include('modals.login-register-modal')

  <!-- Global Success Alert Modal -->
  @include('alerts.success-modal')

  <!-- ==================== MODAL & PAGE SCRIPTS ==================== -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Elements
      const modal = document.getElementById('accessModal');
      const modalBox = modal ? modal.querySelector('.modal-box') : null;
      const openModalBtns = document.querySelectorAll('.open-modal');
      const closeButton = modal ? modal.querySelector('.modal-close') : null;
      const tabButtons = modal ? modal.querySelectorAll('.tab-button') : [];
      const panels = modal ? modal.querySelectorAll('.tab-panel') : [];
      const switchLinks = modal ? modal.querySelectorAll('.modal-switch') : [];
      const togglePasswordBtns = modal ? modal.querySelectorAll('.toggle-password') : [];

      // Open Modal
      function openModal(defaultTab = 'loginTab') {
        if (!modal) return;
        modal.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
        modal.classList.add('opacity-100', 'visible', 'pointer-events-auto');
        if (modalBox) {
          modalBox.classList.remove('scale-95', 'opacity-0');
          modalBox.classList.add('scale-100', 'opacity-100');
        }
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        if (defaultTab) {
          activateTab(defaultTab);
        }
      }

      // Close Modal
      function closeModal() {
        if (!modal) return;
        modal.classList.add('opacity-0', 'invisible', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
        if (modalBox) {
          modalBox.classList.add('scale-95', 'opacity-0');
          modalBox.classList.remove('scale-100', 'opacity-100');
        }
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }

      // Tab Switching (Sign In vs Register)
      function activateTab(targetId) {
        tabButtons.forEach(btn => {
          const isActive = btn.dataset.target === targetId;
          btn.classList.toggle('active', isActive);
          btn.classList.toggle('bg-emerald-800', isActive);
          btn.classList.toggle('text-white', isActive);
          btn.classList.toggle('shadow', isActive);
          btn.classList.toggle('font-bold', isActive);
          btn.classList.toggle('text-slate-700', !isActive);
          btn.classList.toggle('font-semibold', !isActive);
          btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        if (modalBox) {
          if (targetId === 'registerTab') {
            modalBox.classList.remove('max-w-[440px]', 'max-w-[460px]');
            modalBox.classList.add('max-w-[480px]', 'sm:max-w-[580px]', 'md:max-w-[660px]');
          } else {
            modalBox.classList.remove('max-w-[480px]', 'sm:max-w-[580px]', 'md:max-w-[660px]', 'max-w-[560px]');
            modalBox.classList.add('max-w-[440px]');
          }
        }

        panels.forEach(panel => {
          if (panel.id === targetId) {
            panel.classList.remove('hidden', 'absolute', 'inset-x-0', 'top-0', 'h-0', 'overflow-hidden', 'opacity-0', 'pointer-events-none');
            panel.classList.add('block', 'relative', 'opacity-100');
          } else {
            panel.classList.remove('block', 'relative', 'opacity-100');
            panel.classList.add('hidden', 'absolute', 'inset-x-0', 'top-0', 'h-0', 'overflow-hidden', 'opacity-0', 'pointer-events-none');
          }
        });
      }

      // Event Listeners for Open Modal
      openModalBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const targetTab = btn.textContent.trim().toLowerCase().includes('plan') ? 'registerTab' : 'loginTab';
          openModal(targetTab);
        });
      });

      // Automatically keep modal open if there are server-side validation or credential errors
      @if($errors->any() || session('error'))
        const hasRegErr = {{ ($errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('mobile_number') || $errors->has('city_municipality') || $errors->has('barangay') || ($errors->has('username') && old('first_name') !== null)) ? 'true' : 'false' }};
        openModal(hasRegErr ? 'registerTab' : 'loginTab');
      @endif

      // Close Button
      if (closeButton) {
        closeButton.addEventListener('click', closeModal);
      }

      // Click Outside Modal Box
      if (modal) {
        modal.addEventListener('click', (e) => {
          if (e.target === modal) {
            closeModal();
          }
        });
      }

      // Escape Key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.classList.contains('pointer-events-auto')) {
          closeModal();
        }
      });

      // Tab Buttons Click
      tabButtons.forEach(button => {
        button.addEventListener('click', () => activateTab(button.dataset.target));
      });

      // Switch Links ("Create account" / "Sign in instead")
      switchLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          activateTab(link.dataset.switch);
        });
      });

      // Password Visibility Toggle
      togglePasswordBtns.forEach(button => {
        button.addEventListener('click', () => {
          const input = button.previousElementSibling;
          if (input && (input.type === 'password' || input.type === 'text')) {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            button.innerHTML = isPassword 
              ? `<svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`
              : `<svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
          }
        });
      });

      // Register Stepper (Step 1 -> Step 2)
      const registerTab = document.getElementById('registerTab');
      const initialStep = registerTab ? parseInt(registerTab.dataset.initialStep || '1', 10) : 1;
      let currentStep = initialStep;

      function updateStepper(step) {
        currentStep = step;
        for (let i = 1; i <= 2; i++) {
          const content = document.getElementById(`stepContent${i}`);
          if (content) {
            if (i === step) {
              content.classList.remove('hidden');
            } else {
              content.classList.add('hidden');
            }
          }

          const node = modal ? modal.querySelector(`.stepper-node[data-step="${i}"]`) : null;
          if (node) {
            const bubble = node.querySelector('.step-bubble');
            const label = node.querySelector('.step-label');
            if (i < step) {
              bubble.className = 'step-bubble w-6 h-6 rounded-full bg-emerald-800 text-white font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all shadow-xs';
              bubble.innerHTML = '✓';
              label.className = 'step-label text-[10px] font-medium text-slate-700 mt-0.5';
            } else if (i === step) {
              bubble.className = 'step-bubble w-6 h-6 rounded-full bg-emerald-800 text-white font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all shadow-xs';
              bubble.innerHTML = i;
              label.className = 'step-label text-[10px] font-medium text-slate-700 mt-0.5';
            } else {
              bubble.className = 'step-bubble w-6 h-6 rounded-full bg-slate-200 text-slate-600 font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all';
              bubble.innerHTML = i;
              label.className = 'step-label text-[10px] font-medium text-slate-400 mt-0.5';
            }
          }
        }

        const progressBar = document.getElementById('stepperProgressBar');
        if (progressBar) {
          const percentage = ((step - 1) / 1) * 100;
          progressBar.style.width = `${percentage}%`;
        }
      }

      if (registerTab) {
        updateStepper(initialStep);
      }

      if (modal) {
        modal.querySelectorAll('.btn-next-step').forEach(btn => {
          btn.addEventListener('click', () => {
            const currentContent = document.getElementById(`stepContent${currentStep}`);
            if (currentContent) {
              const inputs = currentContent.querySelectorAll('input, select');
              let isValid = true;
              for (const input of inputs) {
                if (!input.checkValidity()) {
                  input.reportValidity();
                  isValid = false;
                  break;
                }
              }
              if (isValid) {
                const nextStep = parseInt(btn.dataset.next, 10);
                updateStepper(nextStep);
              }
            }
          });
        });

        modal.querySelectorAll('.btn-prev-step').forEach(btn => {
          btn.addEventListener('click', () => {
            const prevStep = parseInt(btn.dataset.prev, 10);
            updateStepper(prevStep);
          });
        });

        // Form Submit Loading State & Success Modal Interception
        modal.querySelectorAll('form').forEach(form => {
          form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = form.querySelector('.modal-submit-btn');
            const textSpan = submitBtn ? submitBtn.querySelector('.btn-text') : null;
            const spinnerSpan = submitBtn ? submitBtn.querySelector('.btn-spinner') : null;

            function setBtnLoading(isLoading) {
              if (!submitBtn) return;
              if (isLoading) {
                if (textSpan) { textSpan.classList.add('hidden'); textSpan.classList.remove('flex'); }
                if (spinnerSpan) { spinnerSpan.classList.remove('hidden'); spinnerSpan.classList.add('flex'); }
                submitBtn.classList.add('pointer-events-none', 'opacity-80');
              } else {
                if (textSpan) { textSpan.classList.remove('hidden'); textSpan.classList.add('flex'); }
                if (spinnerSpan) { spinnerSpan.classList.add('hidden'); spinnerSpan.classList.remove('flex'); }
                submitBtn.classList.remove('pointer-events-none', 'opacity-80');
              }
            }

            setBtnLoading(true);

            try {
              const formData = new FormData(form);
              const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                || form.querySelector('input[name="_token"]')?.value;

              const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                  'Accept': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': csrfToken
                },
                body: formData
              });

              const result = await response.json().catch(() => null);

              if (response.ok && result && result.success) {
                // Close login/register modal immediately
                closeModal();

                // Show professional Success Modal before redirecting
                if (typeof window.showAuthSuccessModal === 'function') {
                  window.showAuthSuccessModal({
                    title: result.title,
                    message: result.message,
                    user: result.user,
                    redirect: result.redirect
                  });
                } else {
                  window.location.href = result.redirect || '/user/dashboard';
                }
                return;
              }

              // Handle validation or lockout failures without closing the modal
              setBtnLoading(false);

              if (result) {
                if (result.locked) {
                  // Re-render or reload to activate live lockout timer state
                  form.submit();
                  return;
                }
                
                // Show clean "Credentials incorrect." alert
                let errorBox = document.getElementById('modalLoginErrorAlert');
                if (!errorBox) {
                  errorBox = document.createElement('div');
                  errorBox.id = 'modalLoginErrorAlert';
                  errorBox.className = 'p-2.5 text-xs font-medium rounded-xl bg-rose-50 border border-rose-200 flex items-center gap-2 text-rose-700 animate-shake';
                  errorBox.innerHTML = `
                    <svg class="w-4 h-4 text-rose-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="12" y1="8" x2="12" y2="12"></line>
                      <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>${result.message || 'Credentials incorrect.'}</span>
                  `;
                  form.insertBefore(errorBox, form.querySelector('.space-y-0.5') || form.firstChild);
                } else {
                  errorBox.classList.remove('hidden', 'animate-shake');
                  void errorBox.offsetWidth; // trigger reflow for animation
                  errorBox.classList.add('animate-shake');
                  const msgSpan = errorBox.querySelector('span');
                  if (msgSpan) msgSpan.textContent = result.message || 'Credentials incorrect.';
                }

                // Highlight username and password inputs
                const usernameInput = document.getElementById('modalLoginUsername');
                const passwordInput = document.getElementById('modalPassword');
                if (usernameInput) {
                  usernameInput.classList.add('border-rose-300', 'focus:border-rose-500', 'focus:ring-rose-500/20', 'bg-rose-50/10');
                }
                if (passwordInput) {
                  passwordInput.classList.add('border-rose-300', 'focus:border-rose-500', 'focus:ring-rose-500/20', 'bg-rose-50/10');
                }
              } else {
                // Fallback to standard submission
                form.submit();
              }
            } catch (err) {
              // Network fallback: native form submission
              form.submit();
            }
          });
        });

        // Live Lockout Countdown Timer
        const timerContainer = document.getElementById('lockoutTimerContainer');
        const countdownText = document.getElementById('lockoutCountdownText');
        const loginSubmitBtn = document.getElementById('loginSubmitBtn');
        const loginSubmitBtnText = document.getElementById('loginSubmitBtnText');
        const modalUsernameInput = document.getElementById('modalLoginUsername');
        const modalPasswordInput = document.getElementById('modalPassword');
        const lockoutAlertBox = document.getElementById('lockoutAlertBox');

        if (timerContainer && countdownText) {
          let totalSeconds = parseInt(timerContainer.dataset.seconds || '0', 10);

          function formatTime(sec) {
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
          }

          countdownText.textContent = formatTime(totalSeconds);

          const timerInterval = setInterval(() => {
            totalSeconds--;
            if (totalSeconds <= 0) {
              clearInterval(timerInterval);
              countdownText.textContent = '00:00';

              if (lockoutAlertBox) {
                lockoutAlertBox.className = 'p-2.5 text-xs rounded-xl bg-emerald-50 border border-emerald-200/90 flex items-center gap-2 text-emerald-800 font-medium transition-all duration-300';
                lockoutAlertBox.innerHTML = `
                  <svg class="w-4 h-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg>
                  <span>Lockout ended. You may now sign in.</span>
                `;
              }

              if (loginSubmitBtn) {
                loginSubmitBtn.disabled = false;
                loginSubmitBtn.classList.remove('bg-slate-400', 'cursor-not-allowed', 'opacity-75');
                loginSubmitBtn.classList.add('bg-emerald-800', 'hover:bg-emerald-900', 'cursor-pointer');
                if (loginSubmitBtnText) loginSubmitBtnText.textContent = 'Sign In';
              }

              if (modalUsernameInput) {
                modalUsernameInput.disabled = false;
                modalUsernameInput.classList.remove('opacity-65', 'cursor-not-allowed', 'bg-slate-50');
              }
              if (modalPasswordInput) {
                modalPasswordInput.disabled = false;
                modalPasswordInput.classList.remove('opacity-65', 'cursor-not-allowed', 'bg-slate-50');
              }
            } else {
              countdownText.textContent = formatTime(totalSeconds);
            }
          }, 1000);
        }
      }

      // Modern Sticky Header & Bottom Glow Line on Scroll
      const siteNav = document.getElementById('siteNav');
      const navScrollLine = document.getElementById('navScrollLine');
      const navProgressBar = document.getElementById('navProgressBar');

      if (siteNav) {
        window.addEventListener('scroll', () => {
          const scrollY = window.scrollY;
          const docHeight = document.documentElement.scrollHeight - window.innerHeight;
          const scrollPercent = docHeight > 0 ? (scrollY / docHeight) * 100 : 0;

          if (scrollY > 20) {
            siteNav.classList.add('shadow-md', 'border-transparent');
            siteNav.classList.remove('border-[#D4D9CB]/80');
            if (navScrollLine) navScrollLine.classList.remove('opacity-0');
            if (navScrollLine) navScrollLine.classList.add('opacity-100');
            if (navProgressBar) {
              navProgressBar.classList.remove('opacity-0');
              navProgressBar.classList.add('opacity-100');
              navProgressBar.style.width = `${Math.min(scrollPercent, 100)}%`;
            }
          } else {
            siteNav.classList.remove('shadow-md', 'border-transparent');
            siteNav.classList.add('border-[#D4D9CB]/80');
            if (navScrollLine) {
              navScrollLine.classList.remove('opacity-100');
              navScrollLine.classList.add('opacity-0');
            }
            if (navProgressBar) {
              navProgressBar.classList.remove('opacity-100');
              navProgressBar.classList.add('opacity-0');
              navProgressBar.style.width = '0%';
            }
          }
        }, { passive: true });
      }

      // Smooth Modern Scroll Reveal Animations
      const revealElements = document.querySelectorAll('.reveal-on-scroll');
      if ('IntersectionObserver' in window && revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              observer.unobserve(entry.target);
            }
          });
        }, {
          root: null,
          rootMargin: '0px 0px -40px 0px',
          threshold: 0.08
        });

        revealElements.forEach(el => revealObserver.observe(el));
      } else {
        // Fallback for older browsers
        revealElements.forEach(el => el.classList.add('is-visible'));
      }
    });
  </script>

  @auth
    @include('modals.logout-modal')
  @endauth

</body>
</html>
