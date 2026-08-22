@extends('layouts.app', [
    'title' => 'Kabatanga Falls & Eco-Park · BaliTour',
    'subtitle' => 'Destination Showcase & Interactive Route Map',
    'portal' => 'user',
    'active' => 'explore'
])

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
  #destinationMap, #adminPickerMap {
    height: 480px;
    width: 100%;
    border-radius: 1.5rem;
    z-index: 10;
  }
  .leaflet-popup-content-wrapper {
    border-radius: 1rem;
    padding: 4px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
  }
  .pulse-marker {
    background: #0F52BA;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 4px rgba(15, 82, 186, 0.35);
    animation: pulseAnimation 2s infinite;
  }
  @keyframes pulseAnimation {
    0% { box-shadow: 0 0 0 0 rgba(15, 82, 186, 0.6); }
    70% { box-shadow: 0 0 0 12px rgba(15, 82, 186, 0); }
    100% { box-shadow: 0 0 0 0 rgba(15, 82, 186, 0); }
  }
</style>
@endpush

@section('content')
<div x-data="destinationShowcase()" x-init="initMap()" class="space-y-8 pb-16">

  <!-- Top Breadcrumb & Prototype Notice -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-emerald-900/10 border border-emerald-800/20 px-5 py-3.5 rounded-2xl">
    <div class="flex items-center gap-2 text-xs font-semibold text-forest-900">
      <a href="/user/explore-places" class="hover:underline flex items-center gap-1 text-ink-600 hover:text-forest-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Explore
      </a>
      <span class="text-ink-400">/</span>
      <span class="text-forest-900 font-bold">Falls & Nature</span>
      <span class="text-ink-400">/</span>
      <span class="text-ink-600 truncate">Kabatanga Falls</span>
    </div>
    <div class="inline-flex items-center gap-2 self-start sm:self-auto rounded-full bg-forest-900 px-3 py-1 text-[11px] font-semibold text-cream-100 shadow-xs">
      <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
      Interactive Prototype · Leaflet OSRM Route Demo
    </div>
  </div>

  <!-- Hero Header Card -->
  <section class="relative overflow-hidden rounded-[2.5rem] bg-forest-900 text-cream-50 shadow-xl">
    <div class="relative h-[22rem] sm:h-[28rem] lg:h-[32rem] w-full overflow-hidden">
      <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80" 
           alt="Kabatanga Falls" 
           class="h-full w-full object-cover opacity-90 transition duration-700 hover:scale-105">
      <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/40 to-black/20"></div>
      
      <!-- Badges & Quick actions -->
      <div class="absolute top-6 left-6 right-6 flex items-center justify-between">
        <div class="flex flex-wrap gap-2">
          <span class="inline-flex items-center gap-1.5 rounded-full bg-forest-900/80 backdrop-blur-md px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-sage-300 border border-sage-300/30">
            🌿 Falls / Nature
          </span>
          <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-700/80 backdrop-blur-md px-3.5 py-1.5 text-xs font-semibold text-cream-50">
            Open Today · 8:00 AM - 5:00 PM
          </span>
        </div>
        <button @click="bookmarked = !bookmarked" 
                class="rounded-full bg-white/20 backdrop-blur-md p-3 text-cream-50 hover:bg-white hover:text-forest-900 transition shadow-lg">
          <svg class="h-5 w-5" :fill="bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
          </svg>
        </button>
      </div>

      <!-- Hero Bottom Content -->
      <div class="absolute bottom-0 inset-x-0 p-6 sm:p-10">
        <div class="max-w-3xl">
          <h1 class="font-serif text-3xl sm:text-5xl font-bold tracking-tight text-white leading-tight">
            Kabatanga Falls & Eco-Park
          </h1>
          <p class="mt-3 text-sm sm:text-base text-cream-100/90 leading-relaxed line-clamp-2">
            A tranquil multi-tiered natural waterfall tucked within the tropical hills of Balingasag, featuring cool crystal waters, shaded trails, and picnic pavilions.
          </p>

          <div class="mt-6 flex flex-wrap items-center gap-4 text-xs sm:text-sm font-medium">
            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-2 rounded-xl text-cream-50">
              <span class="text-amber-400 text-base">★</span>
              <span class="font-bold text-white">4.8</span>
              <span class="text-cream-200/75">(42 Reviews)</span>
            </div>
            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-2 rounded-xl text-cream-50">
              <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              <span>Brgy. Samay, Balingasag, Misamis Oriental</span>
            </div>
            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-2 rounded-xl text-cream-50">
              <span class="text-emerald-400 font-bold">₱50.00</span>
              <span class="text-cream-200/75">Entrance Fee</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Grid: Tabs & Interaction Left (2.2fr) vs Info Sidebar Right (1fr) -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- Left Column: Navigation Tabs & Tab Content Panels -->
    <div class="lg:col-span-2 space-y-6">
      
      <!-- Sticky Tab Navigation Bar -->
      <div class="flex items-center gap-2 border-b border-cream-200 pb-1 overflow-x-auto scrollbar-none">
        <button @click="activeTab = 'map'; setTimeout(() => resizeMap(), 200)" 
                :class="activeTab === 'map' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-white text-ink-600 hover:bg-cream-100 hover:text-forest-900 font-medium'" 
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center gap-2 shrink-0">
          <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
          Interactive Map & Trail Route
        </button>

        <button @click="activeTab = 'gallery'" 
                :class="activeTab === 'gallery' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-white text-ink-600 hover:bg-cream-100 hover:text-forest-900 font-medium'" 
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center gap-2 shrink-0">
          <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Photo & Video Gallery (6)
        </button>

        <button @click="activeTab = 'reviews'" 
                :class="activeTab === 'reviews' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-white text-ink-600 hover:bg-cream-100 hover:text-forest-900 font-medium'" 
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center gap-2 shrink-0">
          <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
          Reviews & Ratings (42)
        </button>

        <button @click="activeTab = 'planner'" 
                :class="activeTab === 'planner' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-white text-ink-600 hover:bg-cream-100 hover:text-forest-900 font-medium'" 
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center gap-2 shrink-0">
          <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Plan Visit Date
        </button>

        <button @click="activeTab = 'admin-picker'; setTimeout(() => resizeAdminMap(), 200)" 
                :class="activeTab === 'admin-picker' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-emerald-100 text-forest-900 hover:bg-emerald-200 font-medium'" 
                class="px-4 py-2 rounded-2xl text-xs transition flex items-center gap-1.5 shrink-0 ml-auto border border-emerald-300">
          <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
          Admin Picker Tool Demo
        </button>
      </div>

      <!-- TAB 1: INTERACTIVE LEAFLET MAP & TRAIL ROUTE -->
      <div x-show="activeTab === 'map'" x-transition class="space-y-4">
        
        <!-- Live Distance & Route Control Card -->
        <div class="rounded-3xl border border-cream-200/80 bg-white p-5 sm:p-6 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <span class="text-[11px] font-bold uppercase tracking-wider text-forest-700 bg-forest-50 px-2.5 py-1 rounded-md">Live GPS Routing Engine</span>
              <h2 class="mt-2 text-xl font-bold text-ink-950">Tourist Location to Destination Trail</h2>
              <p class="mt-1 text-xs sm:text-sm text-ink-600">
                Calculates real road distance and draws the trail route directly on the Leaflet map via OSRM.
              </p>
            </div>
            
            <!-- Distance indicator badge -->
            <div class="flex items-center gap-3 bg-cream-50 border border-cream-200 px-4 py-3 rounded-2xl shrink-0">
              <div class="h-10 w-10 rounded-xl bg-forest-900 text-emerald-300 flex items-center justify-center font-bold text-sm">
                🚗
              </div>
              <div>
                <p class="text-[10px] uppercase font-bold tracking-wider text-ink-400">Road Distance</p>
                <p class="text-base font-extrabold text-forest-900" x-text="routeDistanceText || 'Calculating route...'"></p>
                <p class="text-[10px] text-ink-600" x-text="routeDurationText ? '~' + routeDurationText + ' drive' : 'via Balingasag Provincial Rd'"></p>
              </div>
            </div>
          </div>

          <!-- Location Test Controls & Actions -->
          <div class="mt-4 pt-4 border-t border-cream-100 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2">
              <span class="font-semibold text-ink-900">Your Simulated Location:</span>
              <button @click="setUserLocation(8.7455, 124.7745, 'Balingasag Town Center (Plaza)')" 
                      :class="userLocName.includes('Plaza') ? 'bg-forest-900 text-white' : 'bg-cream-100 text-ink-900 hover:bg-cream-200'"
                      class="px-2.5 py-1.5 rounded-lg transition font-medium">
                🏛️ Town Plaza
              </button>
              <button @click="setUserLocation(8.7360, 124.7680, 'Balingasag Boulevard / Coastal')" 
                      :class="userLocName.includes('Boulevard') ? 'bg-forest-900 text-white' : 'bg-cream-100 text-ink-900 hover:bg-cream-200'"
                      class="px-2.5 py-1.5 rounded-lg transition font-medium">
                🌊 Boulevard
              </button>
              <button @click="detectRealLocation()" 
                      class="px-2.5 py-1.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Use My Real GPS
              </button>
            </div>

            <!-- Get Directions Outer Link -->
            <a :href="'https://www.google.com/maps/dir/?api=1&destination=' + destLat + ',' + destLng" 
               target="_blank" 
               class="inline-flex items-center gap-1.5 font-bold text-forest-900 hover:text-emerald-700 bg-sage-300/30 px-3 py-1.5 rounded-xl transition">
              <span>Open in Google Maps</span>
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
          </div>
        </div>

        <!-- Leaflet Map Container -->
        <div class="relative overflow-hidden rounded-[2rem] border border-cream-200/80 bg-slate-100 shadow-md">
          <div id="destinationMap"></div>
          
          <!-- Map Overlay Status Bar -->
          <div class="absolute bottom-4 left-4 right-4 z-20 pointer-events-none">
            <div class="bg-white/95 backdrop-blur-md border border-cream-200 px-4 py-2.5 rounded-2xl shadow-lg flex items-center justify-between text-xs pointer-events-auto">
              <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-blue-600 border-2 border-white shadow-xs"></span>
                <span class="font-medium text-ink-900 truncate">From: <strong x-text="userLocName"></strong></span>
              </div>
              <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-emerald-700 border-2 border-white shadow-xs"></span>
                <span class="font-medium text-ink-900">To: <strong>Kabatanga Falls</strong></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: GALLERY (PHOTOS & ADMIN-UPLOADED VIDEOS) -->
      <div x-show="activeTab === 'gallery'" x-transition class="space-y-6">
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h2 class="text-xl font-bold text-ink-950">Curated Media Showcase</h2>
              <p class="text-xs text-ink-600">High-resolution photos & video footage uploaded and verified by Tourism Admins.</p>
            </div>
            <span class="text-xs font-semibold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
              Official Media
            </span>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
            <template x-for="(item, idx) in galleryItems" :key="idx">
              <div @click="selectedMedia = item" 
                   class="group relative h-44 rounded-2xl overflow-hidden cursor-pointer bg-cream-100 border border-cream-200/60 shadow-xs">
                <img :src="item.src" :alt="item.title" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                  <span class="text-xs font-medium text-white line-clamp-1" x-text="item.title"></span>
                </div>
                <template x-if="item.type === 'video'">
                  <div class="absolute top-2 right-2 h-7 w-7 rounded-full bg-black/60 backdrop-blur-xs flex items-center justify-center text-white text-xs">
                    ▶
                  </div>
                </template>
              </div>
            </template>
          </div>
        </div>
      </div>

      <!-- TAB 3: VISITOR REVIEWS & RATINGS -->
      <div x-show="activeTab === 'reviews'" x-transition class="space-y-6">
        
        <!-- Review Summary & Submit Form -->
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm space-y-6">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-cream-100">
            <div class="flex items-center gap-4">
              <div class="text-center bg-forest-900 text-cream-50 p-4 rounded-2xl">
                <p class="text-3xl font-extrabold">4.8</p>
                <p class="text-[11px] text-sage-300 mt-0.5">★★★★★</p>
              </div>
              <div>
                <h2 class="text-lg font-bold text-ink-950">Overall Visitor Rating</h2>
                <p class="text-xs text-ink-600">Based on 42 verified community traveler reviews</p>
                <p class="text-[11px] text-emerald-700 font-semibold mt-1">✓ 96% of travelers recommend this place</p>
              </div>
            </div>

            <button @click="showReviewForm = !showReviewForm" 
                    class="rounded-xl bg-forest-900 px-4 py-2.5 text-xs font-semibold text-cream-50 hover:bg-forest-800 transition shrink-0">
              <span x-text="showReviewForm ? 'Cancel Review' : '+ Leave a Review'"></span>
            </button>
          </div>

          <!-- Interactive Review Submission Box (One Review per tourist) -->
          <div x-show="showReviewForm" x-transition class="bg-cream-50 border border-cream-200/80 p-5 rounded-2xl space-y-4">
            <h3 class="text-sm font-bold text-forest-900">Share Your Experience at Kabatanga Falls</h3>
            <p class="text-xs text-ink-600">Your review will be published immediately to help other tourists plan their visit.</p>

            <div>
              <label class="block text-xs font-bold text-ink-900 mb-1.5">Select Star Rating *</label>
              <div class="flex items-center gap-2 text-2xl cursor-pointer">
                <template x-for="star in [1,2,3,4,5]" :key="star">
                  <span @click="newReview.rating = star" 
                        :class="star <= newReview.rating ? 'text-amber-400 scale-110' : 'text-cream-300 hover:text-amber-300'"
                        class="transition transform">★</span>
                </template>
                <span class="text-xs font-bold text-ink-900 ml-2" x-text="newReview.rating + ' of 5 Stars'"></span>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-ink-900 mb-1.5">When did you visit? (Optional)</label>
              <input type="date" x-model="newReview.visitDate" class="w-full sm:w-64 rounded-xl border border-cream-200 bg-white px-3 py-2 text-xs text-ink-900 focus:border-forest-900 focus:outline-hidden">
            </div>

            <div>
              <label class="block text-xs font-bold text-ink-900 mb-1.5">Your Review / Tips for others *</label>
              <textarea x-model="newReview.comment" rows="3" placeholder="Tell travelers about the road condition, water coolness, or what to bring..." class="w-full rounded-xl border border-cream-200 bg-white p-3 text-xs text-ink-900 focus:border-forest-900 focus:outline-hidden"></textarea>
            </div>

            <button @click="submitReview()" class="rounded-xl bg-forest-900 px-5 py-2.5 text-xs font-bold text-cream-50 hover:bg-forest-800 transition">
              Publish Review
            </button>
          </div>

          <!-- Existing Reviews List -->
          <div class="space-y-4 pt-2">
            <template x-for="(rev, idx) in reviewsList" :key="idx">
              <div class="p-4 rounded-2xl bg-white border border-cream-200/60 shadow-xs space-y-2">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-full bg-forest-800 text-cream-100 font-bold flex items-center justify-center text-xs" x-text="rev.name[0]"></div>
                    <div>
                      <p class="text-xs font-bold text-ink-950" x-text="rev.name"></p>
                      <p class="text-[10px] text-ink-400" x-text="rev.time + (rev.visitDate ? ' · Visited on ' + rev.visitDate : '')"></p>
                    </div>
                  </div>
                  <div class="text-amber-400 text-xs font-bold" x-text="'★'.repeat(rev.rating)"></div>
                </div>
                <p class="text-xs text-ink-700 leading-relaxed" x-text="rev.comment"></p>
              </div>
            </template>
          </div>
        </div>
      </div>

      <!-- TAB 4: VISIT DATE PLANNER -->
      <div x-show="activeTab === 'planner'" x-transition class="space-y-6">
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm space-y-5">
          <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-forest-700 bg-forest-50 px-2.5 py-1 rounded-md">Travel Scheduler</span>
            <h2 class="mt-2 text-xl font-bold text-ink-950">Plan Your Visit to Kabatanga Falls</h2>
            <p class="text-xs text-ink-600">Save a target date for this destination to your personal BaliTour travel itinerary.</p>
          </div>

          <div class="grid sm:grid-cols-2 gap-4 pt-2">
            <div>
              <label class="block text-xs font-bold text-ink-900 mb-1.5">Planned Visit Date *</label>
              <input type="date" x-model="visitPlanDate" class="w-full rounded-xl border border-cream-200 bg-cream-50/50 px-3.5 py-2.5 text-xs text-ink-900 focus:border-forest-900 focus:bg-white focus:outline-hidden">
            </div>
            <div>
              <label class="block text-xs font-bold text-ink-900 mb-1.5">Companion / Group Size</label>
              <select x-model="visitPlanGroup" class="w-full rounded-xl border border-cream-200 bg-cream-50/50 px-3.5 py-2.5 text-xs text-ink-900 focus:border-forest-900 focus:bg-white focus:outline-hidden">
                <option value="solo">Solo Explorer (1)</option>
                <option value="couple">Couple / Pair (2)</option>
                <option value="family">Family / Group (3-6)</option>
                <option value="large">Tour Group (7+)</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-ink-900 mb-1.5">Personal Notes & Checklist</label>
            <textarea x-model="visitPlanNotes" rows="2" placeholder="e.g., Bring extra swimwear, waterproof bag, snacks..." class="w-full rounded-xl border border-cream-200 bg-cream-50/50 p-3 text-xs text-ink-900 focus:border-forest-900 focus:bg-white focus:outline-hidden"></textarea>
          </div>

          <div class="flex items-center gap-3">
            <button @click="saveVisitPlan()" class="rounded-xl bg-forest-900 px-6 py-2.5 text-xs font-bold text-cream-50 hover:bg-forest-800 transition">
              Save to My Travel List
            </button>
            <span x-show="planSaved" x-transition class="text-xs font-bold text-emerald-700">✓ Added to your Travel Schedule!</span>
          </div>
        </div>
      </div>

      <!-- TAB 5: ADMIN LOCATION PICKER DEMO (LEAFLET DRAGGABLE PIN) -->
      <div x-show="activeTab === 'admin-picker'" x-transition class="space-y-4">
        <div class="rounded-3xl border-2 border-emerald-300 bg-emerald-50/50 p-6 shadow-sm space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
              <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-900 bg-emerald-200/80 px-2.5 py-1 rounded-md">Admin Location Manager Tool</span>
              <h2 class="mt-2 text-xl font-bold text-ink-950">Interactive Destination Coordinates Picker</h2>
              <p class="text-xs text-ink-700">
                Click anywhere on the map or drag the pin to set exact destination coordinates. Latitude & Longitude update automatically.
              </p>
            </div>
            <div class="bg-white border border-emerald-200 px-4 py-2 rounded-xl text-xs font-mono">
              <p class="text-ink-500">Lat: <strong class="text-forest-900" x-text="adminPickerLat.toFixed(6)"></strong></p>
              <p class="text-ink-500">Lng: <strong class="text-forest-900" x-text="adminPickerLng.toFixed(6)"></strong></p>
            </div>
          </div>

          <!-- Leaflet Admin Picker Map -->
          <div class="relative overflow-hidden rounded-[2rem] border border-emerald-300/80 bg-slate-100 shadow-md">
            <div id="adminPickerMap"></div>
          </div>

          <div class="flex items-center justify-between text-xs text-ink-600 bg-white p-3 rounded-xl border border-emerald-200">
            <span>💡 <strong>Tip for Admin:</strong> Drag the orange pin to refine spot positioning down to the exact entrance gate.</span>
            <button @click="applyAdminCoords()" class="font-bold text-emerald-800 hover:underline">
              Save Coordinates →
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Right Column: Destination Overview & Fast Facts Sidebar -->
    <div class="space-y-6">
      
      <!-- Key Information Box -->
      <div class="rounded-[2rem] border border-cream-200/80 bg-white p-6 shadow-sm space-y-6">
        <h3 class="text-base font-bold text-ink-950 border-b border-cream-100 pb-3">Destination Information</h3>

        <div class="space-y-4 text-xs">
          <!-- Category -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              🏷️
            </div>
            <div>
              <p class="font-bold text-ink-900">Category</p>
              <p class="text-ink-600">Falls & Eco-Nature Park</p>
            </div>
          </div>

          <!-- Operating Hours -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              🕐
            </div>
            <div>
              <p class="font-bold text-ink-900">Operating Hours</p>
              <p class="text-ink-600">Monday – Sunday: 8:00 AM – 5:00 PM</p>
            </div>
          </div>

          <!-- Entrance Fee -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              💵
            </div>
            <div>
              <p class="font-bold text-ink-900">Entrance Fees</p>
              <p class="text-ink-600">₱50.00 (Adults) · ₱25.00 (Kids & Seniors)</p>
            </div>
          </div>

          <!-- Address -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              📍
            </div>
            <div>
              <p class="font-bold text-ink-900">Location Address</p>
              <p class="text-ink-600">Barangay Samay, Municipality of Balingasag, Misamis Oriental, 9005</p>
            </div>
          </div>

          <!-- Contact -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              📞
            </div>
            <div>
              <p class="font-bold text-ink-900">Tourism Contact</p>
              <p class="text-ink-600">(088) 333-2140 · tourism@balingasag.gov.ph</p>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-2 space-y-2.5">
          <button @click="activeTab = 'planner'" class="w-full rounded-2xl bg-forest-900 py-3 text-xs font-bold text-cream-50 hover:bg-forest-800 transition shadow-sm flex items-center justify-center gap-2">
            <span>📅 Plan My Visit</span>
          </button>
          
          <button @click="activeTab = 'reviews'; showReviewForm = true" class="w-full rounded-2xl border border-forest-900/30 bg-cream-50 py-3 text-xs font-bold text-forest-900 hover:bg-cream-100 transition flex items-center justify-center gap-2">
            <span>⭐ Leave a Review</span>
          </button>
        </div>
      </div>

      <!-- Nearby Categories Quick Links -->
      <div class="rounded-[2rem] border border-cream-200/80 bg-white p-6 shadow-sm space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-400">Explore Nearby Categories</h3>
        
        <div class="flex flex-wrap gap-2 text-xs">
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">☕ Café</span>
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">🏨 Hotel</span>
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">🌊 Boulevard</span>
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">🏖️ Seashore</span>
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">🏛️ Memory Square</span>
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">🏫 School</span>
          <span class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition cursor-pointer">💪 Public Gym</span>
        </div>
      </div>

    </div>

  </div>

  <!-- Lightbox Modal for Gallery Photos -->
  <div x-show="selectedMedia" 
       x-transition 
       @keydown.escape.window="selectedMedia = null"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" 
       style="display: none;">
    <div @click.away="selectedMedia = null" class="relative max-w-4xl w-full bg-forest-950 rounded-3xl overflow-hidden shadow-2xl">
      <button @click="selectedMedia = null" class="absolute top-4 right-4 z-10 rounded-full bg-black/60 p-2 text-white hover:bg-black transition">
        ✕
      </button>
      <img :src="selectedMedia?.src" :alt="selectedMedia?.title" class="w-full max-h-[75vh] object-contain bg-black">
      <div class="p-4 text-cream-50 bg-forest-900">
        <p class="text-sm font-bold" x-text="selectedMedia?.title"></p>
        <p class="text-xs text-sage-300 mt-0.5">Admin Verified Media · Balingasag Tourism</p>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<!-- Leaflet JS CDN -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
function destinationShowcase() {
  return {
    activeTab: 'map',
    bookmarked: false,
    showReviewForm: false,
    planSaved: false,
    selectedMedia: null,
    
    // Destination Coordinates (Kabatanga Falls, Balingasag)
    destLat: 8.7558,
    destLng: 124.8150,
    
    // Tourist User Location Coordinates (Defaults to Balingasag Town Center)
    userLat: 8.7455,
    userLng: 124.7745,
    userLocName: 'Balingasag Town Plaza (Simulated)',
    
    // Calculated Route Information
    routeDistanceText: '',
    routeDurationText: '',
    
    // Leaflet Objects
    map: null,
    userMarker: null,
    destMarker: null,
    routeLayer: null,
    
    // Admin Picker Tool Data
    adminMap: null,
    adminMarker: null,
    adminPickerLat: 8.7558,
    adminPickerLng: 124.8150,
    
    // Visit Planner Form State
    visitPlanDate: new Date(Date.now() + 86400000 * 3).toISOString().split('T')[0],
    visitPlanGroup: 'family',
    visitPlanNotes: '',
    
    // Review Form State
    newReview: {
      rating: 5,
      visitDate: '',
      comment: ''
    },
    
    // Sample Curated Gallery Items (Uploaded by Admin)
    galleryItems: [
      { src: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1000&q=80', title: 'Main Cascade Waterfall & Basin', type: 'image' },
      { src: 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&w=1000&q=80', title: 'Forest Trail Pathway & Shaded Footpaths', type: 'image' },
      { src: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80', title: 'Lower Stream Swimming Pool', type: 'image' },
      { src: 'https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1000&q=80', title: 'Picnic Cottages & Rest Area', type: 'image' },
      { src: 'https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1000&q=80', title: 'Scenic Bamboo Bridge Crossing', type: 'image' },
      { src: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1000&q=80', title: 'Aerial Drone View of Eco-Park', type: 'video' }
    ],
    
    // Sample Community Reviews
    reviewsList: [
      {
        name: 'Maria Elena Santos',
        rating: 5,
        time: '2 days ago',
        visitDate: '2026-08-18',
        comment: 'Very refreshing and peaceful place! The road from the town center takes about 12 minutes. Clean water and polite staff at the entrance.'
      },
      {
        name: 'Kenji Takahashi',
        rating: 5,
        time: '1 week ago',
        visitDate: '2026-08-12',
        comment: 'The nature trail is lush and shaded. Perfect for families wanting a quick escape from the coastal heat.'
      },
      {
        name: 'Roberto Valderrama',
        rating: 4,
        time: '2 weeks ago',
        visitDate: '2026-08-05',
        comment: 'Great spot for swimming! Best to visit in the morning around 9 AM when the sun shines directly into the cascade basin.'
      }
    ],

    initMap() {
      this.$nextTick(() => {
        // 1. Initialize Leaflet Tourist Map
        this.map = L.map('destinationMap', {
          zoomControl: true
        }).setView([this.destLat, this.destLng], 13);

        // Standard OpenStreetMap Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors',
          maxZoom: 19
        }).addTo(this.map);

        // Custom Destination Marker Icon
        const destIcon = L.divIcon({
          className: 'custom-dest-pin',
          html: `<div style="background:#1B3A2E; color:#A9C79B; border:3px solid white; border-radius:50%; width:38px; height:38px; display:flex; align-items:center; justify-content:center; font-size:18px; box-shadow:0 8px 16px rgba(0,0,0,0.3);">🌿</div>`,
          iconSize: [38, 38],
          iconAnchor: [19, 19]
        });

        this.destMarker = L.marker([this.destLat, this.destLng], { icon: destIcon })
          .addTo(this.map)
          .bindPopup('<b>Kabatanga Falls & Eco-Park</b><br><span style="font-size:11px; color:#666;">Brgy. Samay, Balingasag</span>');

        // Draw initial Route & Marker
        this.updateRoute();

        // 2. Initialize Admin Location Picker Map
        this.initAdminPicker();
      });
    },

    setUserLocation(lat, lng, name) {
      this.userLat = lat;
      this.userLng = lng;
      this.userLocName = name;
      this.updateRoute();
    },

    detectRealLocation() {
      if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
          (pos) => {
            this.setUserLocation(pos.coords.latitude, pos.coords.longitude, 'Your Real Device GPS');
          },
          (err) => {
            alert('Location permission denied or unavailable. Using Balingasag Town Center.');
          }
        );
      } else {
        alert('Geolocation is not supported by your browser.');
      }
    },

    updateRoute() {
      if (!this.map) return;

      // Update or create User Marker
      const userIcon = L.divIcon({
        className: 'pulse-marker',
        html: `<div style="width:16px; height:16px; border-radius:50%; background:#0F52BA;"></div>`,
        iconSize: [16, 16],
        iconAnchor: [8, 8]
      });

      if (this.userMarker) {
        this.userMarker.setLatLng([this.userLat, this.userLng]);
      } else {
        this.userMarker = L.marker([this.userLat, this.userLng], { icon: userIcon })
          .addTo(this.map)
          .bindPopup('<b>Your Current Location</b><br><span style="font-size:11px;">' + this.userLocName + '</span>');
      }

      // Fetch Real Road Trail via OSRM Public Routing API
      const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${this.userLng},${this.userLat};${this.destLng},${this.destLat}?overview=full&geometries=geojson`;

      fetch(osrmUrl)
        .then(res => res.json())
        .then(data => {
          if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
            const route = data.routes[0];
            const distanceKm = (route.distance / 1000).toFixed(1);
            const durationMin = Math.round(route.duration / 60);

            this.routeDistanceText = distanceKm + ' km';
            this.routeDurationText = durationMin + ' mins';

            // Remove existing route layer if any
            if (this.routeLayer) {
              this.map.removeLayer(this.routeLayer);
            }

            // Draw route line polyline with styling
            this.routeLayer = L.geoJSON(route.geometry, {
              style: {
                color: '#0F52BA',
                weight: 5,
                opacity: 0.85,
                dashArray: '2, 6',
                lineJoin: 'round'
              }
            }).addTo(this.map);

            // Fit map bounds to encompass both user and destination
            const bounds = L.latLngBounds([
              [this.userLat, this.userLng],
              [this.destLat, this.destLng]
            ]);
            this.map.fitBounds(bounds, { padding: [60, 60] });
          } else {
            this.fallbackStraightLine();
          }
        })
        .catch(err => {
          this.fallbackStraightLine();
        });
    },

    fallbackStraightLine() {
      // Direct distance calculation fallback (Haversine formula)
      const R = 6371; // km
      const dLat = (this.destLat - this.userLat) * Math.PI / 180;
      const dLon = (this.destLng - this.userLng) * Math.PI / 180;
      const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(this.userLat * Math.PI / 180) * Math.cos(this.destLat * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      const d = (R * c).toFixed(1);

      this.routeDistanceText = d + ' km (direct)';
      this.routeDurationText = Math.round(d * 2.5) + ' mins';

      if (this.routeLayer) this.map.removeLayer(this.routeLayer);
      this.routeLayer = L.polyline([[this.userLat, this.userLng], [this.destLat, this.destLng]], {
        color: '#00A86B',
        weight: 4,
        dashArray: '6, 6'
      }).addTo(this.map);

      this.map.fitBounds([[this.userLat, this.userLng], [this.destLat, this.destLng]], { padding: [50, 50] });
    },

    resizeMap() {
      if (this.map) this.map.invalidateSize();
    },

    resizeAdminMap() {
      if (this.adminMap) this.adminMap.invalidateSize();
    },

    initAdminPicker() {
      const pickerContainer = document.getElementById('adminPickerMap');
      if (!pickerContainer) return;

      this.adminMap = L.map('adminPickerMap').setView([this.adminPickerLat, this.adminPickerLng], 14);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
      }).addTo(this.adminMap);

      const pickerIcon = L.divIcon({
        className: 'custom-admin-pin',
        html: `<div style="background:#F4A460; color:#152C24; border:3px solid white; border-radius:50%; width:34px; height:34px; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:bold; box-shadow:0 8px 16px rgba(0,0,0,0.3);">📍</div>`,
        iconSize: [34, 34],
        iconAnchor: [17, 17]
      });

      this.adminMarker = L.marker([this.adminPickerLat, this.adminPickerLng], {
        icon: pickerIcon,
        draggable: true
      }).addTo(this.adminMap);

      this.adminMarker.on('dragend', (e) => {
        const pos = e.target.getLatLng();
        this.adminPickerLat = pos.lat;
        this.adminPickerLng = pos.lng;
      });

      this.adminMap.on('click', (e) => {
        this.adminPickerLat = e.latlng.lat;
        this.adminPickerLng = e.latlng.lng;
        this.adminMarker.setLatLng(e.latlng);
      });
    },

    applyAdminCoords() {
      this.destLat = this.adminPickerLat;
      this.destLng = this.adminPickerLng;
      this.destMarker.setLatLng([this.destLat, this.destLng]);
      this.activeTab = 'map';
      setTimeout(() => {
        this.resizeMap();
        this.updateRoute();
      }, 200);
      alert(`Coordinates saved!\nLat: ${this.destLat.toFixed(6)}\nLng: ${this.destLng.toFixed(6)}`);
    },

    submitReview() {
      if (!this.newReview.comment.trim()) {
        alert('Please write a short review or tip before publishing.');
        return;
      }

      this.reviewsList.unshift({
        name: 'You (Current Tourist)',
        rating: this.newReview.rating,
        time: 'Just now',
        visitDate: this.newReview.visitDate || null,
        comment: this.newReview.comment
      });

      this.newReview.comment = '';
      this.showReviewForm = false;
      alert('Your review has been published immediately!');
    },

    saveVisitPlan() {
      if (!this.visitPlanDate) {
        alert('Please select a visit date.');
        return;
      }
      this.planSaved = true;
      setTimeout(() => {
        this.planSaved = false;
      }, 4000);
    }
  }
}
</script>
@endpush
