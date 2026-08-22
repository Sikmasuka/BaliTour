@extends('tourist.layout')

@section('title', 'Interactive Map Explorer · Balingasag Tourism')
@section('page-subtitle', 'Map Explorer')
@section('full-bleed', true)

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
  #exploreFullMap { 
    height: 100%; 
    width: 100%; 
    z-index: 1; 
  }

  /* Leaflet custom UI styling */
  .leaflet-popup-content-wrapper {
    background: #ffffff;
    border-radius: 1rem;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 16px 32px -4px rgba(9, 30, 20, 0.18);
    border: 1px solid #CCD8D0;
  }
  .leaflet-popup-content {
    margin: 0;
    line-height: 1.4;
    font-family: 'Inter', sans-serif;
  }
  .leaflet-popup-tip {
    background: #ffffff;
  }

  /* Custom map pin styling */
  .custom-map-pin {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(9, 30, 20, 0.25);
  }
  .custom-map-pin:hover {
    transform: scale(1.22) translateY(-3px);
    z-index: 9999 !important;
  }
  .pin-active {
    transform: scale(1.3) translateY(-5px);
    box-shadow: 0 0 0 3.5px #1B5E41, 0 8px 18px rgba(9, 30, 20, 0.4) !important;
    z-index: 99999 !important;
  }
</style>
@endpush

@php
    $destinationsList = $destinations ?? collect();
    $currentCategory = $category ?? request('category', 'all');
    $currentSearch = $search ?? request('search', '');
    
    // Nature & Coastal harmonized category palette
    $categoryMeta = [
        'all' => ['emoji' => '🌟', 'label' => 'All Spots', 'color' => '#103625'],
        'falls_nature' => ['emoji' => '🌿', 'label' => 'Falls & Nature', 'color' => '#1B5E41'],
        'boulevard' => ['emoji' => '🌊', 'label' => 'Boulevard', 'color' => '#1B6B76'],
        'seashore' => ['emoji' => '🏖️', 'label' => 'Seashore', 'color' => '#23838E'],
        'memory_square' => ['emoji' => '🏛️', 'label' => 'Memory Square', 'color' => '#634882'],
        'church_heritage' => ['emoji' => '⛪', 'label' => 'Church & Heritage', 'color' => '#563D74'],
        'cafe' => ['emoji' => '☕', 'label' => 'Café', 'color' => '#A66B24'],
        'hotel' => ['emoji' => '🏨', 'label' => 'Hotel', 'color' => '#945B1C'],
        'school' => ['emoji' => '🏫', 'label' => 'School', 'color' => '#257954'],
        'gym' => ['emoji' => '💪', 'label' => 'Public Gym', 'color' => '#3D584B'],
        'market' => ['emoji' => '🛍️', 'label' => 'Market', 'color' => '#B8782E'],
        'other' => ['emoji' => '📍', 'label' => 'Landmark', 'color' => '#4D6D5E'],
    ];

    // Format map payload
    $rawMapSpots = isset($mapDestinations) && count($mapDestinations) > 0 ? $mapDestinations : $destinationsList;
    $mapSpotsData = $rawMapSpots->map(function ($item) use ($categoryMeta) {
        $cat = $item->category ?? 'other';
        $meta = $categoryMeta[$cat] ?? $categoryMeta['other'];
        return [
            'id' => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
            'category' => $cat,
            'category_label' => $meta['label'],
            'emoji' => $meta['emoji'],
            'color' => $meta['color'],
            'latitude' => (float)$item->latitude,
            'longitude' => (float)$item->longitude,
            'address' => $item->address,
            'short_description' => $item->short_description ?: Str::limit($item->description, 80),
            'entrance_fee' => $item->formatted_entrance_fee,
            'cover_image' => $item->cover_image ?: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80',
            'average_rating' => $item->average_rating > 0 ? $item->average_rating : 'New',
            'reviews_count' => $item->reviews_count ?? $item->reviews->count(),
        ];
    })->values();
@endphp

@section('content')
  <!-- TRUE FULL-PAGE MAP CANVAS CONTAINER -->
  <div id="fullMapExplorer" class="relative w-full h-full flex-1 overflow-hidden bg-mineral-100 select-none">
    
    <!-- 1. FULL-WIDTH & FULL-HEIGHT MAP ENGINE -->
    <div id="exploreFullMap" class="absolute inset-0 w-full h-full z-0"></div>

    <!-- 2. TOP FLOATING COMMAND BAR (Search, Filters, Quick Actions) -->
    <div class="absolute top-3 inset-x-3 sm:inset-x-4 z-[1000] pointer-events-none flex flex-col gap-2">
      <div class="flex items-center justify-between gap-2.5 flex-wrap">
        
        <!-- Left: Search & Filter Pill Group -->
        <div class="pointer-events-auto flex items-center gap-2 flex-wrap">
          
          <!-- Toggle Drawer Button (Desktop & Mobile) -->
          <button type="button" id="toggleDrawerBtn" 
                  class="inline-flex items-center gap-1.5 rounded-2xl bg-white/95 backdrop-blur-md hover:bg-forest-50 text-forest-950 px-3.5 py-2 text-xs font-bold border border-mineral-200 shadow-sm transition active:scale-95 cursor-pointer"
                  title="Toggle Places Drawer">
            <span id="toggleDrawerIcon" class="text-forest-700 font-bold">◀</span>
            <span id="toggleDrawerText">Places ({{ count($mapSpotsData) }})</span>
          </button>

          <!-- Floating Instant Search Box with Live Geocoding Suggestions -->
          <div class="relative w-64 sm:w-88">
            <input type="text" id="liveSearchInput" value="{{ $currentSearch }}" placeholder="Search school, cafe, landmark, or street..." 
                   autocomplete="off"
                   class="w-full rounded-2xl bg-white/95 backdrop-blur-md border border-mineral-200 px-3.5 py-2 pl-9 pr-7 text-xs text-forest-950 placeholder-ink-500 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-700/20 focus:outline-hidden transition shadow-sm">
            <svg class="absolute left-3 top-2.5 h-4 w-4 text-forest-700 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <button type="button" id="clearSearchBtn" class="hidden absolute right-2.5 top-2 text-ink-400 hover:text-ink-700 text-xs font-bold p-0.5 cursor-pointer">✕</button>

            <!-- Search Suggestion Dropdown for Tourist -->
            <div id="touristSearchDropdown" class="absolute left-0 right-0 top-full mt-1.5 hidden max-h-64 overflow-y-auto rounded-2xl border border-mineral-200 bg-white/98 backdrop-blur-md shadow-2xl ring-1 ring-black/5 z-[2000]">
              <div id="touristSearchDropdownContent" class="divide-y divide-mineral-100 text-xs"></div>
            </div>
          </div>

        </div>

        <!-- Right: Map Controls Group -->
        <div class="pointer-events-auto flex items-center gap-1.5">
          <!-- Recenter Balingasag Button -->
          <button type="button" id="recenterMapBtn" 
                  class="inline-flex items-center gap-1.5 rounded-2xl bg-white/95 backdrop-blur-md hover:bg-forest-50 text-forest-950 px-3.5 py-2 text-xs font-bold border border-mineral-200 shadow-sm transition active:scale-95 cursor-pointer"
                  title="Reset view to Balingasag center">
            <svg class="h-3.5 w-3.5 text-forest-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
            <span class="hidden md:inline">Center Balingasag</span>
          </button>

          <!-- Locate User GPS Button -->
          <button type="button" id="locateUserBtn" 
                  class="inline-flex items-center gap-1.5 rounded-2xl bg-forest-700 hover:bg-forest-800 text-white px-3.5 py-2 text-xs font-bold shadow-sm transition active:scale-95 cursor-pointer"
                  title="Find your current GPS location">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
            <span class="hidden sm:inline">My GPS</span>
          </button>

          <!-- Fullscreen Toggle Button -->
          <button type="button" id="fullscreenToggleBtn" 
                  class="inline-flex items-center justify-center h-8.5 w-8.5 rounded-2xl bg-white/95 backdrop-blur-md hover:bg-forest-50 text-forest-950 border border-mineral-200 shadow-sm transition active:scale-95 cursor-pointer"
                  title="Toggle Fullscreen">
            <svg id="fullscreenIcon" class="h-3.5 w-3.5 text-forest-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
            </svg>
          </button>
        </div>

      </div>

      <!-- Horizontal Scrollable Category Filter Pills -->
      <div class="pointer-events-auto flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none text-xs max-w-full">
        @foreach($categoryMeta as $catKey => $catData)
          @php
            $isActive = ($currentCategory === $catKey);
          @endphp
          <a href="{{ route('user.explore-places', ['category' => $catKey, 'search' => $currentSearch]) }}" 
             class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl transition-all duration-150 shrink-0 text-[11px] font-bold shadow-xs {{ $isActive ? 'bg-forest-900 text-white border border-forest-900 ring-2 ring-forest-700/30' : 'bg-white/95 backdrop-blur-md text-ink-700 hover:bg-forest-50 hover:text-forest-950 border border-mineral-200' }}">
            <span>{{ $catData['emoji'] }}</span>
            <span>{{ $catData['label'] }}</span>
          </a>
        @endforeach
      </div>

    </div>

    <!-- 3. FLOATING COLLAPSIBLE PLACES DRAWER (Left Overlay Card) -->
    <div id="placesDrawer" 
         class="absolute left-3 sm:left-4 top-28 sm:top-28 bottom-4 w-[340px] sm:w-[380px] max-w-[calc(100vw-24px)] flex flex-col bg-mineral-50/98 backdrop-blur-md border border-mineral-200 rounded-3xl shadow-xl z-[1000] transition-all duration-300 ease-in-out">
      
      <!-- Drawer Header Strip -->
      <div class="flex items-center justify-between px-4 py-3 border-b border-mineral-200 bg-mineral-50/90 rounded-t-3xl shrink-0">
        <div class="flex items-center gap-2 min-w-0">
          <span class="text-base">🌿</span>
          <div class="min-w-0">
            <h2 class="font-serif text-xs sm:text-sm font-bold text-forest-950 truncate">Destinations List</h2>
            <p class="text-[10px] text-ink-600 truncate">Select any destination to focus on map</p>
          </div>
        </div>
        
        <div class="flex items-center gap-1.5 shrink-0">
          <span id="spotCountLabel" class="rounded-full bg-forest-100 text-forest-900 text-[10px] font-bold px-2 py-0.5 border border-forest-200">
            {{ count($mapSpotsData) }} spots
          </span>
          <button type="button" id="closeDrawerInnerBtn" 
                  class="flex h-6.5 w-6.5 items-center justify-center rounded-lg text-ink-500 hover:text-forest-950 hover:bg-mineral-200/60 transition cursor-pointer"
                  title="Hide list">
            ✕
          </button>
        </div>
      </div>

      <!-- Scrollable List of Destination Cards -->
      <div id="cardsContainer" class="flex-1 min-h-0 overflow-y-auto p-3 space-y-2.5 scrollbar-thin scrollbar-thumb-mineral-200 hover:scrollbar-thumb-mineral-300">
        @forelse($destinationsList as $dest)
          @php
            $catMeta = $categoryMeta[$dest->category ?? 'other'] ?? $categoryMeta['other'];
          @endphp
          <article id="card-{{ $dest->id }}" 
                   data-id="{{ $dest->id }}"
                   data-lat="{{ $dest->latitude }}"
                   data-lng="{{ $dest->longitude }}"
                   data-name="{{ strtolower($dest->name) }}"
                   data-address="{{ strtolower($dest->address) }}"
                   data-category="{{ $dest->category }}"
                   onclick="flyToPlace({{ $dest->id }}, {{ $dest->latitude ?: 8.7455 }}, {{ $dest->longitude ?: 124.7745 }})"
                   class="destination-card group relative flex gap-2.5 rounded-2xl bg-white border border-mineral-200 p-2.5 shadow-2xs hover:border-forest-600 hover:bg-forest-50/40 hover:shadow-xs transition-all duration-150 cursor-pointer">
            
            <!-- Cover Thumbnail -->
            <div class="relative h-20 w-20 sm:w-22 shrink-0 overflow-hidden rounded-xl bg-mineral-100 border border-mineral-200/80">
              <img src="{{ $dest->cover_image ?: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=600&q=80' }}" 
                   alt="{{ $dest->name }}" 
                   class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
              <span class="absolute top-1 left-1 rounded-md bg-forest-950/85 backdrop-blur-xs px-1.5 py-0.2 text-[9px] font-bold text-forest-100">
                {{ $catMeta['emoji'] }}
              </span>
            </div>

            <!-- Card Body Content -->
            <div class="flex flex-col flex-1 min-w-0 justify-between">
              <div>
                <div class="flex items-start justify-between gap-1">
                  <h3 class="font-serif text-xs font-bold text-forest-950 truncate group-hover:text-forest-700 transition">
                    {{ $dest->name }}
                  </h3>
                  <div class="flex items-center gap-0.5 text-[10.5px] font-bold text-sand-500 shrink-0">
                    <span>★</span>
                    <span>{{ $dest->average_rating > 0 ? $dest->average_rating : 'New' }}</span>
                  </div>
                </div>

                <p class="text-[10px] text-ink-600 truncate flex items-center gap-1 mt-0.5">
                  <span class="text-forest-700">📍</span>
                  <span class="truncate">{{ $dest->address }}</span>
                </p>

                <p class="mt-0.5 text-[10px] text-ink-500 line-clamp-1 leading-tight">
                  {{ $dest->short_description ?: Str::limit($dest->description, 50) }}
                </p>
              </div>

              <!-- Action Strip -->
              <div class="mt-1.5 pt-1.5 border-t border-mineral-100 flex items-center justify-between gap-2">
                <span class="text-[10.5px] font-bold text-forest-700">
                  {{ $dest->formatted_entrance_fee }}
                </span>

                <div class="flex items-center gap-1.5">
                  <span class="rounded-md bg-mineral-100 group-hover:bg-forest-100 px-2 py-0.5 text-[9.5px] font-bold text-forest-950 transition">
                    Focus 📍
                  </span>
                  <a href="{{ route('destinations.show', $dest->slug) }}" 
                     onclick="event.stopPropagation()"
                     class="rounded-md bg-forest-700 hover:bg-forest-800 px-2 py-0.5 text-[9.5px] font-bold text-white transition shadow-2xs">
                    Details ↗
                  </a>
                </div>
              </div>

            </div>
          </article>
        @empty
          <div class="rounded-2xl bg-white border border-mineral-200 p-5 text-center shadow-2xs">
            <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-forest-50 border border-forest-100 text-forest-700 text-lg mx-auto mb-2">
              🔍
            </div>
            <p class="font-serif text-xs font-bold text-forest-950">No destinations found</p>
            <p class="text-[11px] text-ink-600 mt-0.5">Try clearing filters or searching for another term.</p>
            <a href="{{ route('user.explore-places') }}" class="mt-2.5 inline-flex items-center gap-1 rounded-lg bg-forest-700 hover:bg-forest-800 text-white px-3 py-1 text-xs font-bold transition shadow-2xs">
              <span>↻</span>
              <span>Reset Filters</span>
            </a>
          </div>
        @endforelse
      </div>

    </div>

    <!-- 4. FLOATING CATEGORY LEGEND OVERLAY (Bottom Left) -->
    <div class="absolute bottom-4 left-3 sm:left-4 z-[990] hidden md:flex items-center gap-2.5 rounded-2xl bg-white/95 backdrop-blur-md px-3.5 py-1.5 border border-mineral-200 text-[11px] font-bold text-forest-950 shadow-md">
      <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#1B5E41]"></span> Nature</span>
      <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#1B6B76]"></span> Coast</span>
      <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#634882]"></span> Heritage</span>
      <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#A66B24]"></span> Food & Stays</span>
    </div>

  </div>
@endsection

@push('scripts')
<!-- Leaflet JS CDN -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

@include('tourist.js.explore-map')
@endpush
