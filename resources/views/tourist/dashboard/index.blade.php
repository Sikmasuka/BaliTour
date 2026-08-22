@extends('tourist.layout')

@section('title', 'Traveler Dashboard · Balingasag Tourism')
@section('page-subtitle', 'Traveler Overview')

@php
    $user = Auth::user();
    $profile = $user ? ($user->touristProfile ?? $user->profile) : null;
    $firstName = $profile && $profile->first_name ? $profile->first_name : ($user ? explode(' ', $user->name ?? 'Traveler')[0] : 'Traveler');

    // Featured destinations (clean top 3 spots)
    $featuredDestinations = \App\Models\TouristDestination::with(['reviews'])
        ->where('is_published', true)
        ->latest()
        ->take(3)
        ->get();

    $totalDestinationsCount = \App\Models\TouristDestination::where('is_published', true)->count();
    $userReviewsCount = $user ? \App\Models\DestinationReview::where('user_id', $user->id)->count() : 0;
@endphp

@section('content')
  <!-- 1. CALIBRATED NATURE HERO BANNER -->
  <section class="mb-6 relative overflow-hidden rounded-3xl bg-gradient-to-br from-forest-900 via-forest-900 to-forest-800 border border-forest-700/50 px-6 py-6 sm:px-8 sm:py-7 text-white shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
      <div class="space-y-1.5">
        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-3 py-0.5 text-xs text-forest-100 font-medium">
          <span>🌿 Balingasag Tourism</span>
          <span class="text-white/40">·</span>
          <span>☀️ Coastal & Nature Trails</span>
        </div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-white">
          Welcome back, {{ $firstName }}
        </h1>
        <p class="text-xs sm:text-sm text-forest-100/80 max-w-lg leading-relaxed">
          Plan your upcoming trips, check live trail routes on the map, and manage your saved destinations.
        </p>
      </div>

      <!-- Hero Action CTAs -->
      <div class="flex items-center gap-2.5 shrink-0">
        <a href="{{ route('user.explore-places') }}" 
           class="inline-flex items-center gap-2 rounded-2xl bg-white hover:bg-mineral-50 text-forest-950 px-4 py-2.5 text-xs font-bold transition shadow-xs">
          <span>🗺️ Explore Map</span>
        </a>
        <a href="/user/bookmarks" 
           class="inline-flex items-center gap-2 rounded-2xl bg-white/10 hover:bg-white/15 text-white border border-white/20 px-4 py-2.5 text-xs font-semibold transition">
          <span>❤️ Wishlist</span>
        </a>
      </div>
    </div>
  </section>

  <!-- 2. MINIMALIST COHESIVE 4-STAT METRIC ROW -->
  <section class="mb-6 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
    <!-- Stat 1: Total Attractions -->
    <a href="{{ route('user.explore-places') }}" class="group flex items-center justify-between rounded-2xl bg-white border border-mineral-200 p-4 shadow-2xs hover:border-forest-700/40 hover:shadow-xs transition">
      <div>
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Destinations</p>
        <p class="mt-1 font-serif text-2xl font-bold text-forest-950">{{ $totalDestinationsCount }}</p>
      </div>
      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-forest-50 border border-forest-100 text-forest-800 text-base">
        🏞️
      </div>
    </a>

    <!-- Stat 2: Bookmarks -->
    <a href="/user/bookmarks" class="group flex items-center justify-between rounded-2xl bg-white border border-mineral-200 p-4 shadow-2xs hover:border-forest-700/40 hover:shadow-xs transition">
      <div>
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Saved Places</p>
        <p class="mt-1 font-serif text-2xl font-bold text-forest-950">3</p>
      </div>
      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-forest-50 border border-forest-100 text-forest-800 text-base">
        ❤️
      </div>
    </a>

    <!-- Stat 3: Planned Visits -->
    <a href="/user/booking-history" class="group flex items-center justify-between rounded-2xl bg-white border border-mineral-200 p-4 shadow-2xs hover:border-forest-700/40 hover:shadow-xs transition">
      <div>
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Planned Trips</p>
        <p class="mt-1 font-serif text-2xl font-bold text-forest-950">2</p>
      </div>
      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-forest-50 border border-forest-100 text-forest-800 text-base">
        📅
      </div>
    </a>

    <!-- Stat 4: Reviews Shared -->
    <a href="/user/reviews" class="group flex items-center justify-between rounded-2xl bg-white border border-mineral-200 p-4 shadow-2xs hover:border-forest-700/40 hover:shadow-xs transition">
      <div>
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Reviews</p>
        <p class="mt-1 font-serif text-2xl font-bold text-forest-950">{{ $userReviewsCount > 0 ? $userReviewsCount : 1 }}</p>
      </div>
      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-forest-50 border border-forest-100 text-forest-800 text-base">
        ⭐
      </div>
    </a>
  </section>

  <!-- 3. CLEAN TWO-COLUMN CONTENT GRID -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- LEFT COLUMN (7 Cols): Upcoming Itinerary / Planned Visits -->
    <div class="lg:col-span-7 space-y-4">
      <div class="rounded-3xl bg-white border border-mineral-200 p-5 sm:p-6 shadow-2xs">
        <div class="flex items-center justify-between pb-3.5 border-b border-mineral-100">
          <div>
            <h2 class="font-serif text-base sm:text-lg font-bold text-forest-950">Upcoming Planned Visits</h2>
            <p class="text-xs text-ink-500">Your scheduled destinations and tours</p>
          </div>
          <a href="/user/booking-history" class="text-xs font-bold text-forest-700 hover:text-forest-950 inline-flex items-center gap-1">
            View All &rarr;
          </a>
        </div>

        <div class="mt-4 space-y-3">
          <!-- Planned Item 1 -->
          <div class="flex items-center justify-between gap-3 rounded-2xl border border-mineral-200/80 bg-forest-50/40 p-3.5 hover:bg-forest-50/80 hover:border-forest-300/80 transition">
            <div class="flex items-center gap-3.5 min-w-0">
              <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-forest-900 text-white font-bold text-sm shadow-2xs">
                🌿
              </div>
              <div class="min-w-0">
                <p class="font-bold text-xs sm:text-sm text-forest-950 truncate">Kabatanga Falls Day Hike</p>
                <p class="text-xs text-ink-500 flex items-center gap-1.5 mt-0.5">
                  <span>📅 Sept 15, 2026</span>
                  <span>·</span>
                  <span class="text-forest-700 font-semibold">₱50.00 Entrance</span>
                </p>
              </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
              <span class="rounded-full bg-forest-100 text-forest-800 border border-forest-200 px-2.5 py-0.5 text-[10.5px] font-bold">Upcoming</span>
              <a href="{{ route('user.explore-places') }}" class="rounded-xl bg-forest-900 hover:bg-forest-800 px-3 py-1.5 text-xs font-bold text-white transition shadow-2xs">
                Map ↗
              </a>
            </div>
          </div>

          <!-- Planned Item 2 -->
          <div class="flex items-center justify-between gap-3 rounded-2xl border border-mineral-200/80 bg-forest-50/40 p-3.5 hover:bg-forest-50/80 hover:border-forest-300/80 transition">
            <div class="flex items-center gap-3.5 min-w-0">
              <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-forest-800 text-white font-bold text-sm shadow-2xs">
                🎭
              </div>
              <div class="min-w-0">
                <p class="font-bold text-xs sm:text-sm text-forest-950 truncate">Nyepi Cultural Festival Experience</p>
                <p class="text-xs text-ink-500 flex items-center gap-1.5 mt-0.5">
                  <span>📅 March 11, 2027</span>
                  <span>·</span>
                  <span class="text-ink-600">Plaza Balingasag</span>
                </p>
              </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
              <span class="rounded-full bg-sand-100 text-sand-600 border border-sand-200 px-2.5 py-0.5 text-[10.5px] font-bold">Scheduled</span>
              <a href="/user/booking-history" class="rounded-xl bg-mineral-100 hover:bg-mineral-200 px-3 py-1.5 text-xs font-semibold text-forest-950 transition">
                Details
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN (5 Cols): Featured Destinations -->
    <div class="lg:col-span-5 space-y-4">
      <div class="rounded-3xl bg-white border border-mineral-200 p-5 sm:p-6 shadow-2xs">
        <div class="flex items-center justify-between pb-3.5 border-b border-mineral-100">
          <div>
            <h2 class="font-serif text-base sm:text-lg font-bold text-forest-950">Popular Destinations</h2>
            <p class="text-xs text-ink-500">Top-rated spots in Balingasag</p>
          </div>
          <a href="{{ route('user.explore-places') }}" class="text-xs font-bold text-forest-700 hover:text-forest-950 inline-flex items-center gap-1">
            Explore All &rarr;
          </a>
        </div>

        <div class="mt-4 space-y-3">
          @forelse($featuredDestinations as $dest)
            <a href="{{ route('destinations.show', $dest->slug) }}" 
               class="group flex items-center justify-between gap-3 rounded-2xl border border-mineral-200/70 p-2.5 hover:border-forest-700/40 hover:bg-forest-50/40 transition">
              <div class="flex items-center gap-3 min-w-0">
                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-mineral-100 border border-mineral-200/60">
                  <img src="{{ $dest->cover_image ?: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=400&q=80' }}" 
                       alt="{{ $dest->name }}" 
                       class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                </div>
                <div class="min-w-0">
                  <p class="font-bold text-xs sm:text-sm text-forest-950 truncate group-hover:text-forest-700 transition">
                    {{ $dest->name }}
                  </p>
                  <p class="text-[11px] text-ink-500 truncate mt-0.5">
                    📍 {{ $dest->address }}
                  </p>
                </div>
              </div>
              <div class="flex flex-col items-end shrink-0">
                <span class="text-xs font-bold text-forest-700">{{ $dest->formatted_entrance_fee }}</span>
                <span class="text-[10.5px] font-bold text-sand-500 mt-0.5">★ {{ $dest->average_rating > 0 ? $dest->average_rating : 'New' }}</span>
              </div>
            </a>
          @empty
            <p class="py-6 text-center text-xs text-ink-500">No destinations available currently.</p>
          @endforelse
        </div>
      </div>
    </div>

  </div>

  <!-- 4. CLEAN ASSISTANCE & HOTLINE STRIP (Footer) -->
  <section class="mt-6 rounded-2xl bg-white border border-mineral-200 p-4 shadow-2xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
      <div class="flex items-center gap-2">
        <span class="text-base">🛡️</span>
        <div>
          <span class="font-bold text-forest-950">Balingasag Tourist Assistance:</span>
          <span class="text-ink-600 ml-1">MDRRMO Rescue: <strong class="text-forest-950">(088) 333-2140</strong></span>
          <span class="text-mineral-300 mx-1.5 hidden sm:inline">|</span>
          <span class="text-ink-600">Police: <strong class="text-forest-950">0917-704-5821</strong></span>
        </div>
      </div>
      <a href="mailto:tourism@balingasag.gov.ph" class="text-xs font-bold text-forest-700 hover:text-forest-950 shrink-0">
        tourism@balingasag.gov.ph ↗
      </a>
    </div>
  </section>
@endsection
