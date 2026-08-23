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

    /* Heritage Photo Stack Deck */
    .heritage-stack-container {
      perspective: 1200px;
    }
    .heritage-stack-card {
      transform-style: preserve-3d;
      backface-visibility: hidden;
      transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.45s ease, filter 0.45s ease, box-shadow 0.45s ease;
      will-change: transform, opacity;
    }

    /* Horizontal Kinetic Drift Wall */
    .horizontal-drift-mask {
      -webkit-mask-image: linear-gradient(to right, transparent 0%, black 6%, black 94%, transparent 100%);
      mask-image: linear-gradient(to right, transparent 0%, black 6%, black 94%, transparent 100%);
    }

    .horizontal-drift-row {
      width: 100%;
    }

    .horizontal-drift-track {
      display: flex;
      flex-direction: row;
      will-change: transform;
    }

    .horizontal-drift-tile {
      width: 275px;
      height: 165px;
      flex: 0 0 275px;
      transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.35s ease, border-color 0.35s ease, opacity 0.35s ease;
      will-change: transform;
    }

    @media (min-width: 640px) {
      .horizontal-drift-tile {
        width: 305px;
        height: 175px;
        flex: 0 0 305px;
      }
    }

    .horizontal-drift-tile:hover,
    .horizontal-drift-tile:focus-visible {
      transform: translateY(-6px) scale(1.03);
      box-shadow: 0 22px 35px -10px rgba(0, 0, 0, 0.85), 0 0 0 2px rgba(52, 211, 153, 0.85);
      border-color: rgba(52, 211, 153, 0.9);
      z-index: 20;
    }
  </style>
</head>
<body class="min-h-screen text-slate-900 antialiased selection:bg-emerald-800 selection:text-white bg-[#F3F4EE]">

  <!-- Header / Navigation -->
  @include('landing.header')

  <!-- Main Content Sections -->
  <main id="main-content" class="pt-[54px]">
    @include('landing.hero')
    @include('landing.about')
    @include('landing.destinations')
    @include('landing.experience')
    @include('landing.travel-info')
  </main>

  <!-- Modern Footer -->
  @include('landing.footer')

  <!-- Auth & Alert Modals -->
  @include('modals.login-register-modal')
  @include('alerts.success-modal')

  @auth
    @include('modals.logout-modal')
  @endauth

  <!-- Page & Modal Scripts -->
  @include('landing.scripts')

</body>
</html>
