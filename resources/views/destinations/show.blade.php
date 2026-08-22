@extends('layouts.app', [
    'title' => $destination->name . ' · BaliTour',
    'subtitle' => 'Destination Showcase & Interactive Route Map',
    'portal' => 'user',
    'active' => 'explore'
])

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
  #destinationMap {
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
<div x-data="destinationDetails({
    destLat: {{ $destination->latitude ?? 8.7455 }},
    destLng: {{ $destination->longitude ?? 124.7745 }},
    hasCoords: {{ ($destination->latitude && $destination->longitude) ? 'true' : 'false' }},
    slug: '{{ $destination->slug }}',
    csrfToken: '{{ csrf_token() }}',
    existingPlan: @json($userPlan),
    existingReview: @json($userReview)
})" x-init="initMap()" class="space-y-8 pb-16">

  <!-- Top Breadcrumb -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-cream-100/70 border border-cream-200 px-5 py-3.5 rounded-2xl">
    <div class="flex items-center gap-2 text-xs font-semibold text-forest-900">
      <a href="{{ route('destinations.index') }}" class="hover:underline flex items-center gap-1 text-ink-600 hover:text-forest-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Explore Places
      </a>
      <span class="text-ink-400">/</span>
      <span class="text-forest-900 font-bold">{{ $destination->category_label }}</span>
      <span class="text-ink-400">/</span>
      <span class="text-ink-600 truncate">{{ $destination->name }}</span>
    </div>
    <div class="inline-flex items-center gap-2 self-start sm:self-auto rounded-full bg-forest-900 px-3.5 py-1 text-[11px] font-semibold text-cream-100 shadow-xs">
      <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
      {{ $destination->city_municipality }}, {{ $destination->province }}
    </div>
  </div>

  <!-- Hero Header Card -->
  <section class="relative overflow-hidden rounded-[2.5rem] bg-forest-900 text-cream-50 shadow-xl">
    <div class="relative h-[22rem] sm:h-[28rem] lg:h-[32rem] w-full overflow-hidden">
      <img src="{{ $destination->cover_image ?: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80' }}" 
           alt="{{ $destination->name }}" 
           class="h-full w-full object-cover opacity-90 transition duration-700 hover:scale-105">
      <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/40 to-black/20"></div>
      
      <!-- Top Badges -->
      <div class="absolute top-6 left-6 right-6 flex items-center justify-between">
        <div class="flex flex-wrap gap-2">
          <span class="inline-flex items-center gap-1.5 rounded-full bg-forest-900/80 backdrop-blur-md px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-sage-300 border border-sage-300/30">
            {{ $destination->category_label }}
          </span>
          @if($destination->opening_time && $destination->closing_time)
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-700/80 backdrop-blur-md px-3.5 py-1.5 text-xs font-semibold text-cream-50">
              Hours: {{ date('g:i A', strtotime($destination->opening_time)) }} – {{ date('g:i A', strtotime($destination->closing_time)) }}
            </span>
          @endif
        </div>
      </div>

      <!-- Hero Bottom Content -->
      <div class="absolute bottom-0 inset-x-0 p-6 sm:p-10">
        <div class="max-w-3xl">
          <h1 class="font-serif text-3xl sm:text-5xl font-bold tracking-tight text-white leading-tight">
            {{ $destination->name }}
          </h1>
          <p class="mt-3 text-sm sm:text-base text-cream-100/90 leading-relaxed line-clamp-2">
            {{ $destination->short_description ?: Str::limit($destination->description, 160) }}
          </p>

          <div class="mt-6 flex flex-wrap items-center gap-4 text-xs sm:text-sm font-medium">
            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-2 rounded-xl text-cream-50">
              <span class="text-amber-400 text-base">★</span>
              <span class="font-bold text-white">{{ $destination->average_rating > 0 ? $destination->average_rating : 'New' }}</span>
              <span class="text-cream-200/75">({{ $destination->reviews_count }} {{ Str::plural('Review', $destination->reviews_count) }})</span>
            </div>
            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-2 rounded-xl text-cream-50">
              <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              <span>{{ $destination->address }}</span>
            </div>
            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-2 rounded-xl text-cream-50">
              <span class="text-emerald-400 font-bold">{{ $destination->formatted_entrance_fee }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Grid: Tabs & Content (2.2fr) vs Info Sidebar (1fr) -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- Left Column: Navigation Tabs & Content -->
    <div class="lg:col-span-2 space-y-6">
      
      <!-- Tab Navigation Bar -->
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
          Photo Gallery ({{ $destination->media->count() }})
        </button>

        <button @click="activeTab = 'reviews'" 
                :class="activeTab === 'reviews' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-white text-ink-600 hover:bg-cream-100 hover:text-forest-900 font-medium'" 
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center gap-2 shrink-0">
          <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
          Reviews & Ratings ({{ $destination->reviews_count }})
        </button>

        <button @click="activeTab = 'planner'" 
                :class="activeTab === 'planner' ? 'bg-forest-900 text-cream-50 shadow-md font-semibold' : 'bg-white text-ink-600 hover:bg-cream-100 hover:text-forest-900 font-medium'" 
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center gap-2 shrink-0">
          <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Plan Visit Date
        </button>
      </div>

      <!-- TAB 1: LEAFLET MAP & TRAIL ROUTE -->
      <div x-show="activeTab === 'map'" x-transition class="space-y-4">
        
        <!-- Live Distance Indicator -->
        <div class="rounded-3xl border border-cream-200/80 bg-white p-5 sm:p-6 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <span class="text-[11px] font-bold uppercase tracking-wider text-forest-700 bg-forest-50 px-2.5 py-1 rounded-md">Live GPS Routing Engine</span>
              <h2 class="mt-2 text-xl font-bold text-ink-950">Tourist Location to {{ $destination->name }}</h2>
              <p class="mt-1 text-xs sm:text-sm text-ink-600">
                Calculates real road distance and draws the trail route directly on the Leaflet map via OSRM.
              </p>
            </div>
            
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

          <!-- Location Test Controls -->
          <div class="mt-4 pt-4 border-t border-cream-100 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2">
              <span class="font-semibold text-ink-900">Your Location:</span>
              <button @click="setUserLocation(8.7455, 124.7745, 'Town Plaza')" 
                      :class="userLocName.includes('Plaza') ? 'bg-forest-900 text-white' : 'bg-cream-100 text-ink-900 hover:bg-cream-200'"
                      class="px-2.5 py-1.5 rounded-lg transition font-medium">
                🏛️ Town Plaza
              </button>
              <button @click="setUserLocation(8.7360, 124.7680, 'Boulevard')" 
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

            @if($destination->latitude && $destination->longitude)
              <a href="https://www.google.com/maps/dir/?api=1&destination={{ $destination->latitude }},{{ $destination->longitude }}" 
                 target="_blank" 
                 class="inline-flex items-center gap-1.5 font-bold text-forest-900 hover:text-emerald-700 bg-sage-300/30 px-3 py-1.5 rounded-xl transition">
                <span>Open in Google Maps</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
              </a>
            @endif
          </div>
        </div>

        <!-- Leaflet Map Container -->
        <div class="relative overflow-hidden rounded-[2rem] border border-cream-200/80 bg-slate-100 shadow-md">
          <div id="destinationMap"></div>
          
          <div class="absolute bottom-4 left-4 right-4 z-20 pointer-events-none">
            <div class="bg-white/95 backdrop-blur-md border border-cream-200 px-4 py-2.5 rounded-2xl shadow-lg flex items-center justify-between text-xs pointer-events-auto">
              <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-blue-600 border-2 border-white shadow-xs"></span>
                <span class="font-medium text-ink-900 truncate">From: <strong x-text="userLocName"></strong></span>
              </div>
              <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-emerald-700 border-2 border-white shadow-xs"></span>
                <span class="font-medium text-ink-900">To: <strong>{{ $destination->name }}</strong></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Full Description Card -->
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm space-y-3">
          <h3 class="text-base font-bold text-ink-950">About this Destination</h3>
          <div class="text-xs sm:text-sm text-ink-700 leading-relaxed space-y-3">
            {!! nl2br(e($destination->description ?: $destination->short_description)) !!}
          </div>
        </div>

      </div>

      <!-- TAB 2: MEDIA GALLERY -->
      <div x-show="activeTab === 'gallery'" x-transition class="space-y-6">
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h2 class="text-xl font-bold text-ink-950">Curated Media Gallery</h2>
              <p class="text-xs text-ink-600">Official photos and visual media curated by Balingasag Tourism Administrators.</p>
            </div>
            <span class="text-xs font-semibold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
              Admin Verified
            </span>
          </div>

          @if($destination->media->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
              @foreach($destination->media as $media)
                <div @click="selectedMedia = { src: '{{ $media->url }}', title: '{{ $media->title ?: $destination->name }}' }" 
                     class="group relative h-44 rounded-2xl overflow-hidden cursor-pointer bg-cream-100 border border-cream-200/60 shadow-xs">
                  <img src="{{ $media->url }}" alt="{{ $media->alt_text ?: $destination->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                    <span class="text-xs font-medium text-white line-clamp-1">{{ $media->title ?: $destination->name }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-12 bg-cream-50 rounded-2xl border border-dashed border-cream-200">
              <p class="text-2xl">📸</p>
              <p class="mt-2 text-sm font-semibold text-ink-900">Cover photo is currently the primary image.</p>
              <p class="text-xs text-ink-500">More gallery photos will be uploaded by administrators soon.</p>
            </div>
          @endif
        </div>
      </div>

      <!-- TAB 3: REVIEWS & RATINGS -->
      <div x-show="activeTab === 'reviews'" x-transition class="space-y-6">
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm space-y-6">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-cream-100">
            <div class="flex items-center gap-4">
              <div class="text-center bg-forest-900 text-cream-50 p-4 rounded-2xl">
                <p class="text-3xl font-extrabold">{{ $destination->average_rating > 0 ? $destination->average_rating : '5.0' }}</p>
                <p class="text-[11px] text-sage-300 mt-0.5">★★★★★</p>
              </div>
              <div>
                <h2 class="text-lg font-bold text-ink-950">Overall Visitor Rating</h2>
                <p class="text-xs text-ink-600">Based on {{ $destination->reviews_count }} community traveler {{ Str::plural('review', $destination->reviews_count) }}</p>
                <p class="text-[11px] text-emerald-700 font-semibold mt-1">✓ Instant community feedback system</p>
              </div>
            </div>

            @auth
              <button @click="showReviewForm = !showReviewForm" 
                      class="rounded-xl bg-forest-900 px-4 py-2.5 text-xs font-semibold text-cream-50 hover:bg-forest-800 transition shrink-0">
                <span x-text="showReviewForm ? 'Cancel Review' : '{{ $userReview ? 'Edit Your Review' : '+ Leave a Review' }}'"></span>
              </button>
            @else
              <a href="{{ route('login') }}" class="rounded-xl bg-forest-900 px-4 py-2.5 text-xs font-semibold text-cream-50 hover:bg-forest-800 transition shrink-0">
                Log In to Review
              </a>
            @endauth
          </div>

          <!-- Review Form -->
          @auth
            <div x-show="showReviewForm" x-transition class="bg-cream-50 border border-cream-200/80 p-5 rounded-2xl space-y-4">
              <h3 class="text-sm font-bold text-forest-900">
                {{ $userReview ? 'Update Your Review' : 'Write a Review for ' . $destination->name }}
              </h3>
              <p class="text-xs text-ink-600">Reviews are published immediately for other travelers to see.</p>

              <div>
                <label class="block text-xs font-bold text-ink-900 mb-1.5">Select Star Rating *</label>
                <div class="flex items-center gap-2 text-2xl cursor-pointer">
                  <template x-for="star in [1,2,3,4,5]" :key="star">
                    <span @click="reviewForm.rating = star" 
                          :class="star <= reviewForm.rating ? 'text-amber-400 scale-110' : 'text-cream-300 hover:text-amber-300'"
                          class="transition transform">★</span>
                  </template>
                  <span class="text-xs font-bold text-ink-900 ml-2" x-text="reviewForm.rating + ' of 5 Stars'"></span>
                </div>
              </div>

              <div>
                <label class="block text-xs font-bold text-ink-900 mb-1.5">When did you visit? (Optional)</label>
                <input type="date" x-model="reviewForm.visit_date" class="w-full sm:w-64 rounded-xl border border-cream-200 bg-white px-3 py-2 text-xs text-ink-900 focus:border-forest-900 focus:outline-hidden">
              </div>

              <div>
                <label class="block text-xs font-bold text-ink-900 mb-1.5">Your Feedback / Travel Tips *</label>
                <textarea x-model="reviewForm.comment" rows="3" placeholder="Share tips about the route, fees, best time of day, or what to bring..." class="w-full rounded-xl border border-cream-200 bg-white p-3 text-xs text-ink-900 focus:border-forest-900 focus:outline-hidden"></textarea>
              </div>

              <button @click="submitReviewAjax()" :disabled="reviewSubmitting" class="rounded-xl bg-forest-900 px-5 py-2.5 text-xs font-bold text-cream-50 hover:bg-forest-800 transition disabled:opacity-50">
                <span x-text="reviewSubmitting ? 'Publishing...' : 'Publish Review'"></span>
              </button>
            </div>
          @endauth

          <!-- Reviews List -->
          <div class="space-y-4 pt-2">
            @forelse($destination->reviews as $review)
              <div class="p-4 rounded-2xl bg-white border border-cream-200/60 shadow-xs space-y-2">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-full bg-forest-800 text-cream-100 font-bold flex items-center justify-center text-xs">
                      {{ substr($review->reviewer_name, 0, 1) }}
                    </div>
                    <div>
                      <p class="text-xs font-bold text-ink-950">{{ $review->reviewer_name }}</p>
                      <p class="text-[10px] text-ink-400">
                        {{ $review->created_at->diffForHumans() }}
                        @if($review->visit_date)
                          · Visited on {{ $review->visit_date->format('M d, Y') }}
                        @endif
                      </p>
                    </div>
                  </div>
                  <div class="text-amber-400 text-xs font-bold">
                    {{ str_repeat('★', $review->rating) }}
                  </div>
                </div>
                <p class="text-xs text-ink-700 leading-relaxed">{{ $review->comment }}</p>
              </div>
            @empty
              <div class="text-center py-10 bg-cream-50 rounded-2xl">
                <p class="text-2xl">💬</p>
                <p class="mt-2 text-sm font-semibold text-ink-900">Be the first to review {{ $destination->name }}!</p>
                <p class="text-xs text-ink-500">Your feedback helps future tourists plan memorable visits.</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- TAB 4: VISIT DATE PLANNER -->
      <div x-show="activeTab === 'planner'" x-transition class="space-y-6">
        <div class="rounded-3xl border border-cream-200/80 bg-white p-6 shadow-sm space-y-5">
          <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-forest-700 bg-forest-50 px-2.5 py-1 rounded-md">Travel Scheduler</span>
            <h2 class="mt-2 text-xl font-bold text-ink-950">Plan Your Visit to {{ $destination->name }}</h2>
            <p class="text-xs text-ink-600">Save a target date for this destination to your personal BaliTour travel itinerary.</p>
          </div>

          @auth
            <div class="grid sm:grid-cols-2 gap-4 pt-2">
              <div>
                <label class="block text-xs font-bold text-ink-900 mb-1.5">Planned Visit Date *</label>
                <input type="date" x-model="planForm.planned_date" class="w-full rounded-xl border border-cream-200 bg-cream-50/50 px-3.5 py-2.5 text-xs text-ink-900 focus:border-forest-900 focus:bg-white focus:outline-hidden">
              </div>
              <div>
                <label class="block text-xs font-bold text-ink-900 mb-1.5">Companion / Group Size</label>
                <select x-model="planForm.group_size" class="w-full rounded-xl border border-cream-200 bg-cream-50/50 px-3.5 py-2.5 text-xs text-ink-900 focus:border-forest-900 focus:bg-white focus:outline-hidden">
                  <option value="solo">Solo Explorer (1)</option>
                  <option value="couple">Couple / Pair (2)</option>
                  <option value="family">Family / Group (3-6)</option>
                  <option value="large">Tour Group (7+)</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-ink-900 mb-1.5">Personal Notes & Checklist</label>
              <textarea x-model="planForm.notes" rows="2" placeholder="e.g., Bring extra swimwear, camera, cash for entrance..." class="w-full rounded-xl border border-cream-200 bg-cream-50/50 p-3 text-xs text-ink-900 focus:border-forest-900 focus:bg-white focus:outline-hidden"></textarea>
            </div>

            <div class="flex items-center gap-3">
              <button @click="submitPlanAjax()" :disabled="planSubmitting" class="rounded-xl bg-forest-900 px-6 py-2.5 text-xs font-bold text-cream-50 hover:bg-forest-800 transition disabled:opacity-50">
                <span x-text="planSubmitting ? 'Saving...' : 'Save to My Travel Schedule'"></span>
              </button>
              <span x-show="planSuccess" x-transition class="text-xs font-bold text-emerald-700">✓ Saved to your Travel List!</span>
            </div>
          @else
            <div class="bg-cream-50 p-6 rounded-2xl text-center space-y-3">
              <p class="text-sm font-bold text-forest-900">Please log in to add this destination to your travel planner.</p>
              <a href="{{ route('login') }}" class="inline-flex rounded-xl bg-forest-900 px-5 py-2 text-xs font-bold text-cream-50">Log In</a>
            </div>
          @endauth
        </div>
      </div>

    </div>

    <!-- Right Column: Info Sidebar -->
    <div class="space-y-6">
      
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
              <p class="text-ink-600">{{ $destination->category_label }}</p>
            </div>
          </div>

          <!-- Operating Hours -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              🕐
            </div>
            <div>
              <p class="font-bold text-ink-900">Operating Hours</p>
              <p class="text-ink-600">
                @if($destination->opening_time && $destination->closing_time)
                  {{ date('g:i A', strtotime($destination->opening_time)) }} – {{ date('g:i A', strtotime($destination->closing_time)) }}
                @else
                  Open daily during regular visiting hours
                @endif
              </p>
            </div>
          </div>

          <!-- Entrance Fee -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              💵
            </div>
            <div>
              <p class="font-bold text-ink-900">Entrance Fee</p>
              <p class="text-ink-600">{{ $destination->formatted_entrance_fee }}</p>
            </div>
          </div>

          <!-- Address -->
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
              📍
            </div>
            <div>
              <p class="font-bold text-ink-900">Address</p>
              <p class="text-ink-600">{{ $destination->address }}</p>
            </div>
          </div>

          <!-- Contact -->
          @if($destination->contact_number || $destination->contact_email)
            <div class="flex items-start gap-3">
              <div class="h-8 w-8 rounded-xl bg-forest-50 text-forest-900 flex items-center justify-center shrink-0 font-bold">
                📞
              </div>
              <div>
                <p class="font-bold text-ink-900">Tourism Contact</p>
                <p class="text-ink-600">{{ $destination->contact_number ?: $destination->contact_email }}</p>
              </div>
            </div>
          @endif
        </div>

        <div class="pt-2 space-y-2.5">
          <button @click="activeTab = 'planner'" class="w-full rounded-2xl bg-forest-900 py-3 text-xs font-bold text-cream-50 hover:bg-forest-800 transition shadow-sm flex items-center justify-center gap-2">
            <span>📅 Plan My Visit</span>
          </button>
          
          <button @click="activeTab = 'reviews'; showReviewForm = true" class="w-full rounded-2xl border border-forest-900/30 bg-cream-50 py-3 text-xs font-bold text-forest-900 hover:bg-cream-100 transition flex items-center justify-center gap-2">
            <span>⭐ Leave a Review</span>
          </button>
        </div>
      </div>

      <!-- Categories Filter -->
      <div class="rounded-[2rem] border border-cream-200/80 bg-white p-6 shadow-sm space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-400">Discover More Categories</h3>
        
        <div class="flex flex-wrap gap-2 text-xs">
          <a href="{{ route('destinations.index', ['category' => 'cafe']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">☕ Café</a>
          <a href="{{ route('destinations.index', ['category' => 'hotel']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">🏨 Hotel</a>
          <a href="{{ route('destinations.index', ['category' => 'boulevard']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">🌊 Boulevard</a>
          <a href="{{ route('destinations.index', ['category' => 'seashore']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">🏖️ Seashore</a>
          <a href="{{ route('destinations.index', ['category' => 'memory_square']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">🏛️ Memory Square</a>
          <a href="{{ route('destinations.index', ['category' => 'falls_nature']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">🌿 Falls & Nature</a>
          <a href="{{ route('destinations.index', ['category' => 'church_heritage']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">⛪ Church</a>
          <a href="{{ route('destinations.index', ['category' => 'gym']) }}" class="px-3 py-1.5 rounded-xl bg-cream-100 text-forest-900 font-semibold hover:bg-forest-900 hover:text-white transition">💪 Public Gym</a>
        </div>
      </div>

    </div>

  </div>

  <!-- Lightbox Modal -->
  <div x-show="selectedMedia" 
       x-transition 
       @keydown.escape.window="selectedMedia = null"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" 
       style="display: none;">
    <div @click.away="selectedMedia = null" class="relative max-w-4xl w-full bg-forest-950 rounded-3xl overflow-hidden shadow-2xl">
      <button @click="selectedMedia = null" class="absolute top-4 right-4 z-10 rounded-full bg-black/60 p-2 text-white hover:bg-black transition">✕</button>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
function destinationDetails(config) {
  return {
    activeTab: 'map',
    showReviewForm: false,
    selectedMedia: null,
    reviewSubmitting: false,
    planSubmitting: false,
    planSuccess: false,
    
    destLat: config.destLat,
    destLng: config.destLng,
    hasCoords: config.hasCoords,
    slug: config.slug,
    csrfToken: config.csrfToken,
    
    // User simulated coordinates (Balingasag Town Plaza)
    userLat: 8.7455,
    userLng: 124.7745,
    userLocName: 'Town Plaza (Simulated)',
    
    routeDistanceText: '',
    routeDurationText: '',
    
    map: null,
    userMarker: null,
    destMarker: null,
    routeLayer: null,
    
    reviewForm: {
      rating: config.existingReview ? config.existingReview.rating : 5,
      visit_date: config.existingReview ? config.existingReview.visit_date : '',
      comment: config.existingReview ? config.existingReview.comment : ''
    },
    
    planForm: {
      planned_date: config.existingPlan ? config.existingPlan.planned_date : new Date(Date.now() + 86400000 * 3).toISOString().split('T')[0],
      group_size: config.existingPlan ? config.existingPlan.group_size : 'family',
      notes: config.existingPlan ? config.existingPlan.notes : ''
    },

    initMap() {
      if (!this.hasCoords) return;

      this.$nextTick(() => {
        this.map = L.map('destinationMap').setView([this.destLat, this.destLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors',
          maxZoom: 19
        }).addTo(this.map);

        const destIcon = L.divIcon({
          className: 'custom-dest-pin',
          html: `<div style="background:#1B3A2E; color:#A9C79B; border:3px solid white; border-radius:50%; width:38px; height:38px; display:flex; align-items:center; justify-content:center; font-size:18px; box-shadow:0 8px 16px rgba(0,0,0,0.3);">📍</div>`,
          iconSize: [38, 38],
          iconAnchor: [19, 19]
        });

        this.destMarker = L.marker([this.destLat, this.destLng], { icon: destIcon })
          .addTo(this.map)
          .bindPopup('<b>{{ addslashes($destination->name) }}</b><br><span style="font-size:11px; color:#666;">{{ addslashes($destination->address) }}</span>');

        this.updateRoute();
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
            this.setUserLocation(pos.coords.latitude, pos.coords.longitude, 'Real GPS Location');
          },
          (err) => {
            alert('GPS location unavailable. Using Balingasag Town Center.');
          }
        );
      } else {
        alert('Geolocation is not supported by your browser.');
      }
    },

    updateRoute() {
      if (!this.map || !this.hasCoords) return;

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
          .bindPopup('<b>Your Location</b><br><span style="font-size:11px;">' + this.userLocName + '</span>');
      }

      const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${this.userLng},${this.userLat};${this.destLng},${this.destLat}?overview=full&geometries=geojson`;

      fetch(osrmUrl)
        .then(res => res.json())
        .then(data => {
          if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
            const route = data.routes[0];
            this.routeDistanceText = (route.distance / 1000).toFixed(1) + ' km';
            this.routeDurationText = Math.round(route.duration / 60) + ' mins';

            if (this.routeLayer) this.map.removeLayer(this.routeLayer);

            this.routeLayer = L.geoJSON(route.geometry, {
              style: {
                color: '#0F52BA',
                weight: 5,
                opacity: 0.85,
                dashArray: '2, 6'
              }
            }).addTo(this.map);

            const bounds = L.latLngBounds([
              [this.userLat, this.userLng],
              [this.destLat, this.destLng]
            ]);
            this.map.fitBounds(bounds, { padding: [60, 60] });
          } else {
            this.fallbackStraightLine();
          }
        })
        .catch(() => this.fallbackStraightLine());
    },

    fallbackStraightLine() {
      const R = 6371;
      const dLat = (this.destLat - this.userLat) * Math.PI / 180;
      const dLon = (this.destLng - this.userLng) * Math.PI / 180;
      const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(this.userLat * Math.PI / 180) * Math.cos(this.destLat * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
      const d = (R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a))).toFixed(1);

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

    submitReviewAjax() {
      if (!this.reviewForm.comment.trim()) {
        alert('Please write your review comment.');
        return;
      }

      this.reviewSubmitting = true;

      fetch(`/destinations/${this.slug}/reviews`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': this.csrfToken
        },
        body: JSON.stringify(this.reviewForm)
      })
      .then(res => res.json())
      .then(data => {
        this.reviewSubmitting = false;
        if (data.success) {
          alert('Review published successfully!');
          window.location.reload();
        } else {
          alert(data.message || 'An error occurred.');
        }
      })
      .catch(() => {
        this.reviewSubmitting = false;
        alert('Failed to publish review. Please try again.');
      });
    },

    submitPlanAjax() {
      if (!this.planForm.planned_date) {
        alert('Please select a visit date.');
        return;
      }

      this.planSubmitting = true;

      fetch(`/destinations/${this.slug}/visit-plans`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': this.csrfToken
        },
        body: JSON.stringify(this.planForm)
      })
      .then(res => res.json())
      .then(data => {
        this.planSubmitting = false;
        if (data.success) {
          this.planSuccess = true;
          setTimeout(() => { this.planSuccess = false; }, 4000);
        } else {
          alert(data.message || 'An error occurred.');
        }
      })
      .catch(() => {
        this.planSubmitting = false;
        alert('Failed to save visit plan. Please try again.');
      });
    }
  }
}
</script>
@endpush
