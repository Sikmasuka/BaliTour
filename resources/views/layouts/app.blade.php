@props([
    'title' => null,
    'subtitle' => null,
    'portal' => null, // 'admin', 'user', or auto-detected
    'active' => null
])

@php
    $currentRoute = Route::currentRouteName() ?? '';
    $currentPath = request()->path();
    $isUserPortal = ($portal === 'user' || $portal === 'tourist') || str_starts_with($currentPath, 'user') || str_starts_with($currentPath, 'tourist') || str_starts_with($currentRoute, 'user.') || str_starts_with($currentRoute, 'tourist.');
    $pageTitle = $title ?? ($__env->yieldContent('title') ?: ($isUserPortal ? 'BaliTours Traveler' : 'Balingasag Admin'));
    $pageSubtitle = $subtitle ?? ($__env->yieldContent('page-subtitle') ?: ($isUserPortal ? 'Traveler Portal' : 'Admin Panel'));
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="BaliTour - Municipality of Balingasag Tourism Information System">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $pageTitle }}</title>
  
  <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
  
  <style>
    body { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Playfair Display', serif; }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-thumb { background: #D2DBD4; border-radius: 999px; }
    ::-webkit-scrollbar-thumb:hover { background: #BAC6BD; }
    ::-webkit-scrollbar-track { background: transparent; }
    a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible { 
      outline: 2px solid #1E5E45; 
      outline-offset: 2px; 
    }
    [x-cloak] { display: none !important; }
  </style>
  @stack('styles')
</head>
<body class="min-h-screen bg-mineral-50 text-ink-900 antialiased selection:bg-forest-100 selection:text-forest-950">

  <div class="flex min-h-screen">
    <!-- Global Compact Sidebar Navigation -->
    @include('layouts.sidebar', ['portal' => $portal, 'active' => $active])

    <!-- Main Content Layout Area -->
    <div class="content-wrapper flex min-h-screen {{ View::hasSection('full-bleed') ? 'h-screen max-h-screen overflow-hidden' : '' }} w-full flex-col lg:pl-[250px] transition-all duration-300 ease-in-out">
      
      <!-- Global Application Content Header -->
      @include('layouts.header', [
          'title' => $pageTitle,
          'subtitle' => $pageSubtitle,
          'portal' => $portal
      ])

      <!-- Main Page Content Body -->
      @if(View::hasSection('full-bleed'))
        <main class="w-full flex-1 flex flex-col min-h-0 relative overflow-hidden">
          {{ $slot ?? '' }}
          @yield('content')
        </main>
      @else
        <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
          {{ $slot ?? '' }}
          @yield('content')
        </main>
      @endif

      <!-- Optional Modals Section -->
      @yield('modals')

      <!-- Global Alert & Notification Modals -->
      @include('alerts.success-modal')
      @auth
        @include('modals.logout-modal')
      @endauth

    </div>
  </div>

  @stack('scripts')
</body>
</html>
