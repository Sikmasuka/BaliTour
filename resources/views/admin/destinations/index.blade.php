@extends('admin.layout')

@section('title', 'Manage Destinations')
@section('page-subtitle', 'Coordinates & Information')
@section('destinations-active', 'bg-cream-50 text-forest-900 shadow-sm')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
  .panel-enter { transform: translateX(100%); }
  .panel-open { transform: translateX(0); }
  #adminLocationMap { height: 260px; width: 100%; border-radius: 1rem; z-index: 10; }
</style>
@endpush

@section('content')
  <!-- Page header -->
  <section class="mb-8 flex flex-col gap-4 rounded-3xl bg-forest-900 p-8 sm:flex-row sm:items-center sm:justify-between sm:p-10 shadow-xl">
    <div>
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Destination Control Center</p>
      <h1 class="mt-3 font-serif text-3xl font-medium text-cream-50 sm:text-4xl">Manage Destinations</h1>
      <p class="mt-3 max-w-xl text-sm leading-relaxed text-cream-100/80">
        Create and manage tourist destinations, upload media, and set exact GPS coordinates using the interactive Leaflet map picker.
      </p>
    </div>
    <button id="openAddBtn" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-cream-50 px-5 py-3 text-sm font-bold text-forest-900 shadow-md hover:bg-white transition cursor-pointer">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5v14M5 12h14"/></svg>
      + Add Destination
    </button>
  </section>

  <!-- Stats -->
  <section class="mb-8 grid gap-4 sm:grid-cols-3">
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Total Listed</p>
      <p class="mt-2 font-serif text-3xl font-medium text-forest-900">{{ $totalDestinations ?? count($destinations) }}</p>
    </article>
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Published</p>
      <p class="mt-2 font-serif text-3xl font-medium text-emerald-800">{{ $publishedCount ?? count($destinations) }}</p>
    </article>
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">With Map Coordinates</p>
      <p class="mt-2 font-serif text-3xl font-medium text-forest-900">{{ $withCoordinatesCount ?? count($destinations) }}</p>
    </article>
  </section>

  <!-- Toolbar / Search / Filter -->
  <section class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-cream-200 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" action="{{ route('admin.destinations') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full">
      <div class="relative w-full sm:max-w-sm">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
        <input name="search" value="{{ request('search') }}" type="text" placeholder="Search by name, address…"
          class="w-full rounded-2xl border border-cream-200 bg-cream-50 py-2.5 pl-10 pr-4 text-sm text-ink-900 placeholder:text-ink-400 focus:border-forest-700 focus:bg-white">
      </div>
      <div class="flex items-center gap-2 w-full sm:w-auto">
        <select name="category" onchange="this.form.submit()" class="rounded-2xl border border-cream-200 bg-cream-50 px-3.5 py-2.5 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
          <option value="all">All Categories</option>
          <option value="falls_nature" {{ request('category') === 'falls_nature' ? 'selected' : '' }}>🌿 Falls & Nature</option>
          <option value="boulevard" {{ request('category') === 'boulevard' ? 'selected' : '' }}>🌊 Boulevard</option>
          <option value="seashore" {{ request('category') === 'seashore' ? 'selected' : '' }}>🏖️ Seashore</option>
          <option value="memory_square" {{ request('category') === 'memory_square' ? 'selected' : '' }}>🏛️ Memory Square</option>
          <option value="church_heritage" {{ request('category') === 'church_heritage' ? 'selected' : '' }}>⛪ Church & Heritage</option>
          <option value="cafe" {{ request('category') === 'cafe' ? 'selected' : '' }}>☕ Café</option>
          <option value="hotel" {{ request('category') === 'hotel' ? 'selected' : '' }}>🏨 Hotel</option>
          <option value="school" {{ request('category') === 'school' ? 'selected' : '' }}>🏫 School</option>
          <option value="gym" {{ request('category') === 'gym' ? 'selected' : '' }}>💪 Public Gym</option>
          <option value="market" {{ request('category') === 'market' ? 'selected' : '' }}>🛍️ Market</option>
          <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>📍 Other Landmark</option>
        </select>
        <button type="submit" class="rounded-2xl bg-forest-900 px-4 py-2.5 text-xs font-bold text-cream-50 hover:bg-forest-800 cursor-pointer">Filter</button>
      </div>
    </form>
  </section>

  <!-- Grid of Destinations -->
  <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @forelse($destinations as $dest)
      <article class="group flex flex-col overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200 transition hover:shadow-md">
        <div class="relative aspect-[16/10] w-full overflow-hidden bg-cream-100">
          <img src="{{ $dest->cover_image ?: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80' }}" 
               alt="{{ $dest->name }}" 
               class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
          <span class="absolute left-3 top-3 rounded-full bg-forest-900/80 backdrop-blur-md px-2.5 py-1 text-[11px] font-semibold text-sage-300">
            {{ $dest->category_label }}
          </span>
          <span class="absolute right-3 top-3 rounded-full bg-black/50 backdrop-blur-md px-2.5 py-1 text-[11px] font-bold text-emerald-300">
            {{ $dest->formatted_entrance_fee }}
          </span>
        </div>
        
        <div class="p-5 flex flex-col flex-1">
          <div>
            <h3 class="font-serif text-lg font-bold text-forest-900 truncate">{{ $dest->name }}</h3>
            <p class="mt-1 text-xs text-ink-500 truncate">📍 {{ $dest->address }}</p>
            <p class="mt-2 text-xs text-ink-600 line-clamp-2">{{ $dest->short_description ?: Str::limit($dest->description, 100) }}</p>
          </div>

          <div class="mt-4 pt-3 border-t border-cream-100 flex items-center justify-between text-xs">
            <div class="text-ink-500 font-mono">
              @if($dest->latitude && $dest->longitude)
                <span class="text-emerald-700 font-semibold">📍 Lat: {{ number_format($dest->latitude, 3) }}, Lng: {{ number_format($dest->longitude, 3) }}</span>
              @else
                <span class="text-amber-600">⚠️ No coordinates</span>
              @endif
            </div>
          </div>

          <!-- Admin Action Buttons -->
          <div class="mt-4 pt-3 flex items-center justify-between gap-2">
            <a href="{{ route('destinations.show', $dest->slug) }}" target="_blank" class="rounded-xl bg-cream-100 hover:bg-cream-200 px-3 py-1.5 text-xs font-semibold text-forest-900 transition">
              View Public Page ↗
            </a>
            <div class="flex items-center gap-2">
              <button type="button" 
                      onclick='openEditDestinationModal(@json($dest))' 
                      class="rounded-xl bg-forest-900 hover:bg-forest-800 px-3 py-1.5 text-xs font-bold text-cream-50 transition cursor-pointer">
                Edit
              </button>
              <button type="button" 
                      onclick="confirmDeleteDestination({{ $dest->id }}, '{{ addslashes($dest->name) }}')" 
                      class="rounded-xl border border-red-200 bg-red-50 hover:bg-red-100 px-3 py-1.5 text-xs font-bold text-red-600 transition cursor-pointer">
                Delete
              </button>
            </div>
          </div>

        </div>
      </article>
    @empty
      <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-cream-200">
        <p class="text-3xl">🏞️</p>
        <p class="mt-2 text-base font-bold text-ink-950">No destinations found.</p>
        <p class="text-xs text-ink-500">Click "+ Add Destination" above to add the first tourist spot.</p>
      </div>
    @endforelse
  </section>
@endsection

@section('modals')
  <!-- ===================== ADD/EDIT SLIDE-OVER DRAWER ===================== -->
  <div id="panelOverlay" class="fixed inset-0 z-40 hidden bg-forest-900/40 backdrop-blur-xs" aria-hidden="true"></div>
  <div id="panel" class="panel-enter fixed inset-y-0 right-0 z-50 flex w-full max-w-xl transform flex-col bg-cream-50 shadow-2xl transition-transform duration-300 ease-out"
    role="dialog" aria-modal="true">

    <div class="flex items-center justify-between border-b border-cream-200 bg-white px-6 py-5">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Destination Form</p>
        <h2 id="panelTitle" class="mt-1 font-serif text-2xl font-medium text-forest-900">Add Destination</h2>
      </div>
      <button type="button" id="closePanelBtn" class="rounded-full p-2 text-ink-600 hover:bg-cream-100 cursor-pointer">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
    </div>

    <form id="destinationForm" class="flex-1 space-y-6 overflow-y-auto px-6 py-6">
      <input type="hidden" id="editDestinationId" value="">

      <!-- Basic info -->
      <div class="space-y-4">
        <div>
          <label for="fieldName" class="mb-1 block text-xs font-bold text-ink-900">Destination Name *</label>
          <input id="fieldName" required type="text" placeholder="e.g. Kabatanga Falls & Eco-Park"
            class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-xs font-medium focus:border-forest-700">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label for="fieldCategory" class="mb-1 block text-xs font-bold text-ink-900">Category *</label>
            <select id="fieldCategory" class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-xs font-medium focus:border-forest-700">
              <option value="falls_nature">🌿 Falls & Nature</option>
              <option value="boulevard">🌊 Boulevard</option>
              <option value="seashore">🏖️ Seashore</option>
              <option value="memory_square">🏛️ Memory Square</option>
              <option value="church_heritage">⛪ Church & Heritage</option>
              <option value="cafe">☕ Café</option>
              <option value="hotel">🏨 Hotel</option>
              <option value="school">🏫 School</option>
              <option value="gym">💪 Public Gym</option>
              <option value="market">🛍️ Market</option>
              <option value="other">📍 Other Landmark</option>
            </select>
          </div>
          <div>
            <label for="fieldFee" class="mb-1 block text-xs font-bold text-ink-900">Entrance Fee (₱)</label>
            <input id="fieldFee" type="number" step="0.01" min="0" placeholder="0.00 = Free"
              class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-xs font-medium focus:border-forest-700">
          </div>
        </div>

        <div>
          <label for="fieldAddress" class="mb-1 block text-xs font-bold text-ink-900">Street / Barangay Address *</label>
          <input id="fieldAddress" required type="text" placeholder="e.g. Barangay Samay, Balingasag"
            class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-xs font-medium focus:border-forest-700">
        </div>
      </div>

      <!-- INTERACTIVE LEAFLET LOCATION PICKER -->
      <div class="space-y-3 border-t border-cream-200 pt-5">
        <div class="flex items-center justify-between">
          <label class="text-xs font-bold uppercase tracking-wider text-forest-900">Interactive Map Pin Location *</label>
          <span class="text-[11px] text-ink-500 font-mono">
            Lat: <strong id="readoutLat" class="text-forest-900">8.7455</strong>, Lng: <strong id="readoutLng" class="text-forest-900">124.7745</strong>
          </span>
        </div>
        <p class="text-[11px] text-ink-600">Search landmark, paste Google Maps link, switch to Satellite view, or drag the orange pin to set the exact spot.</p>

        <!-- Accuracy & Search Toolbar -->
        <div class="space-y-2 relative">
          <div class="flex gap-2">
            <div class="relative flex-1">
              <input id="mapSearchInput" type="text" placeholder="Type cafe, school, street, or paste link/coords..." 
                class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2 text-xs text-ink-900 focus:border-forest-700 focus:ring-1 focus:ring-forest-700"
                autocomplete="off"
                oninput="handleLiveSearchInput(this.value)"
                onkeydown="if(event.key==='Enter'){event.preventDefault(); handleMapSearch();}">
              
              <!-- Live Search Suggestions Dropdown -->
              <div id="searchSuggestionsBox" class="absolute left-0 right-0 top-full z-50 mt-1 hidden max-h-56 overflow-y-auto rounded-xl border border-cream-200 bg-white shadow-xl ring-1 ring-black/5">
                <div id="searchSuggestionsContent" class="divide-y divide-cream-100 text-xs"></div>
              </div>
            </div>
            <button type="button" id="mapSearchBtn" onclick="handleMapSearch()" 
              class="inline-flex items-center gap-1.5 rounded-xl bg-forest-900 px-3.5 py-2 text-xs font-semibold text-cream-50 hover:bg-forest-800 transition">
              <svg id="searchIconSvg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
              <span id="searchBtnText">Find</span>
            </button>
            <button type="button" onclick="locateAdminGPS()" title="Use my current device GPS location"
              class="inline-flex items-center gap-1.5 rounded-xl border border-cream-200 bg-cream-50 px-3 py-2 text-xs font-semibold text-forest-900 hover:bg-cream-100 transition">
              <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 6a4 4 0 1 1-4 4 4 4 0 0 1 4-4Z"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
              GPS
            </button>
          </div>
          <div id="searchStatusMsg" class="hidden text-[11px] font-medium"></div>
        </div>

        <!-- Leaflet Map Container inside Drawer -->
        <div class="overflow-hidden rounded-2xl border border-cream-200 shadow-sm bg-slate-100 relative">
          <div id="adminLocationMap" style="height: 280px; width: 100%;"></div>
        </div>

        <input type="hidden" id="fieldLatitude" value="8.7455">
        <input type="hidden" id="fieldLongitude" value="124.7745">
      </div>

      <!-- Description -->
      <div class="space-y-4 border-t border-cream-200 pt-5">
        <div>
          <label for="fieldShort" class="mb-1 block text-xs font-bold text-ink-900">Short Summary</label>
          <textarea id="fieldShort" rows="2" placeholder="Brief summary for cards and search results"
            class="w-full rounded-xl border border-cream-200 bg-white p-3 text-xs focus:border-forest-700"></textarea>
        </div>

        <div>
          <label for="fieldFull" class="mb-1 block text-xs font-bold text-ink-900">Full Description</label>
          <textarea id="fieldFull" rows="3" placeholder="Complete destination details, travel highlights, and tips..."
            class="w-full rounded-xl border border-cream-200 bg-white p-3 text-xs focus:border-forest-700"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label for="fieldOpenTime" class="mb-1 block text-xs font-bold text-ink-900">Opening Time</label>
            <input id="fieldOpenTime" type="time" class="w-full rounded-xl border border-cream-200 bg-white px-3 py-2 text-xs">
          </div>
          <div>
            <label for="fieldCloseTime" class="mb-1 block text-xs font-bold text-ink-900">Closing Time</label>
            <input id="fieldCloseTime" type="time" class="w-full rounded-xl border border-cream-200 bg-white px-3 py-2 text-xs">
          </div>
        </div>

        <div>
          <label for="fieldContact" class="mb-1 block text-xs font-bold text-ink-900">Contact Number or Email</label>
          <input id="fieldContact" type="text" placeholder="(088) 333-2140 / tourism@balingasag.gov.ph"
            class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-xs focus:border-forest-700">
        </div>
      </div>

      <!-- Media & Cover Image -->
      <div class="space-y-3 border-t border-cream-200 pt-5">
        <label for="fieldCoverUrl" class="block text-xs font-bold uppercase tracking-wider text-forest-900">Cover Image URL</label>
        <input id="fieldCoverUrl" type="url" placeholder="https://images.unsplash.com/photo-..."
          class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-xs focus:border-forest-700">
      </div>

    </form>

    <div class="flex items-center justify-end gap-3 border-t border-cream-200 bg-white px-6 py-4">
      <button type="button" id="cancelBtn" class="rounded-2xl border border-cream-200 bg-white px-5 py-2.5 text-xs font-bold text-ink-900 hover:bg-cream-100 cursor-pointer">Cancel</button>
      <button type="button" id="saveDestinationBtn" onclick="saveDestinationForm()" class="rounded-2xl bg-forest-900 px-6 py-2.5 text-xs font-bold text-cream-50 shadow-sm hover:bg-forest-800 cursor-pointer">Save Destination</button>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-forest-900/50 p-4">
    <div class="w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl space-y-4">
      <h3 class="font-serif text-xl font-bold text-forest-900">Confirm Deletion</h3>
      <p class="text-xs text-ink-600">Are you sure you want to remove <strong id="deleteTargetName"></strong> from the tourism registry?</p>
      <div class="flex justify-end gap-3 pt-2">
        <button onclick="closeDeleteModal()" class="rounded-xl border border-cream-200 px-4 py-2 text-xs font-bold cursor-pointer">Cancel</button>
        <button id="confirmDeleteBtn" class="rounded-xl bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700 cursor-pointer">Yes, Delete</button>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Leaflet JS CDN -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const panel = document.getElementById('panel');
    const panelOverlay = document.getElementById('panelOverlay');
    const openAddBtn = document.getElementById('openAddBtn');
    const closePanelBtn = document.getElementById('closePanelBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    
    let adminMap = null;
    let adminMarker = null;
    let deleteId = null;

    function initAdminPickerMap(lat = 8.7455, lng = 124.7745) {
      if (adminMap) {
        adminMap.remove();
      }

      adminMap = L.map('adminLocationMap').setView([lat, lng], 14);

      // Base Layers
      const osmStreet = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
      });

      const esriSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Maxar, Earthstar Geographics',
        maxZoom: 19
      });

      // Default to Street view
      osmStreet.addTo(adminMap);

      // Add Layer Control switcher in top-right
      const baseMaps = {
        "🗺️ Street": osmStreet,
        "🛰️ Satellite": esriSatellite
      };
      L.control.layers(baseMaps, null, { position: 'topright' }).addTo(adminMap);

      const pickerIcon = L.divIcon({
        className: 'custom-admin-pin',
        html: `<div style="background:#F4A460; color:#152C24; border:3px solid white; border-radius:50%; width:34px; height:34px; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:bold; box-shadow:0 8px 16px rgba(0,0,0,0.35); cursor:grab;">📍</div>`,
        iconSize: [34, 34],
        iconAnchor: [17, 17]
      });

      adminMarker = L.marker([lat, lng], {
        icon: pickerIcon,
        draggable: true
      }).addTo(adminMap);

      adminMarker.on('dragend', (e) => {
        const pos = e.target.getLatLng();
        setCoordinates(pos.lat, pos.lng);
      });

      adminMap.on('click', (e) => {
        setCoordinates(e.latlng.lat, e.latlng.lng);
        adminMarker.setLatLng(e.latlng);
      });
    }

    function setCoordinates(lat, lng) {
      document.getElementById('fieldLatitude').value = lat;
      document.getElementById('fieldLongitude').value = lng;
      document.getElementById('readoutLat').textContent = Number(lat).toFixed(6);
      document.getElementById('readoutLng').textContent = Number(lng).toFixed(6);
    }

    function showSearchStatus(text, isError = false) {
      const el = document.getElementById('searchStatusMsg');
      if (!el) return;
      el.textContent = text;
      el.className = `text-[11px] font-medium ${isError ? 'text-rose-600' : 'text-emerald-700'}`;
      el.classList.remove('hidden');
    }

    function updateMapPosition(lat, lng, zoom = 16, label = 'Location updated') {
      setCoordinates(lat, lng);
      if (adminMap && adminMarker) {
        adminMap.setView([lat, lng], zoom);
        adminMarker.setLatLng([lat, lng]);
      }
      showSearchStatus(label, false);
    }

    let searchDebounceTimer = null;

    window.handleLiveSearchInput = function(val) {
      clearTimeout(searchDebounceTimer);
      const query = val.trim();

      if (query.length < 2) {
        hideSuggestions();
        return;
      }

      // Check if raw coordinates or Google Maps link
      if (query.includes('@') || query.includes('http') || /^(-?\d+(\.\d+)?)[,\s]+(-?\d+(\.\d+)?)$/.test(query)) {
        hideSuggestions();
        return;
      }

      searchDebounceTimer = setTimeout(() => {
        executeGeocodeSearch(query, true);
      }, 350);
    };

    function hideSuggestions() {
      const box = document.getElementById('searchSuggestionsBox');
      if (box) box.classList.add('hidden');
    }

    function getPlaceIcon(type = '', osmKey = '', osmVal = '') {
      const combined = `${type} ${osmKey} ${osmVal}`.toLowerCase();
      if (combined.includes('cafe') || combined.includes('coffee')) return '☕';
      if (combined.includes('school') || combined.includes('college') || combined.includes('university')) return '🏫';
      if (combined.includes('restaurant') || combined.includes('food') || combined.includes('fast_food')) return '🍽️';
      if (combined.includes('hotel') || combined.includes('resort') || combined.includes('guest_house')) return '🏨';
      if (combined.includes('beach') || combined.includes('seashore') || combined.includes('sea')) return '🏖️';
      if (combined.includes('church') || combined.includes('cathedral') || combined.includes('place_of_worship')) return '⛪';
      if (combined.includes('park') || combined.includes('garden') || combined.includes('nature')) return '🌿';
      if (combined.includes('gym') || combined.includes('fitness')) return '💪';
      if (combined.includes('market') || combined.includes('mall') || combined.includes('shop')) return '🛍️';
      return '📍';
    }

    function renderSuggestions(places) {
      const box = document.getElementById('searchSuggestionsBox');
      const container = document.getElementById('searchSuggestionsContent');
      if (!box || !container) return;

      if (!places || places.length === 0) {
        container.innerHTML = `<div class="p-3 text-center text-ink-500">No matching places found. Try a different keyword or paste coordinates.</div>`;
        box.classList.remove('hidden');
        return;
      }

      let html = '';
      places.forEach(p => {
        const icon = getPlaceIcon(p.type, p.osm_key, p.osm_val);
        const name = p.name || p.street || 'Location';
        const sub = [p.street, p.district, p.city, p.state].filter(Boolean).join(', ');

        html += `
          <button type="button" 
            onclick="selectSuggestion(${p.lat}, ${p.lng}, '${name.replace(/'/g, "\\'")}', '${sub.replace(/'/g, "\\'")}')"
            class="w-full text-left px-3.5 py-2.5 hover:bg-forest-50 flex items-start gap-2.5 transition cursor-pointer">
            <span class="text-base shrink-0 mt-0.5">${icon}</span>
            <div class="min-w-0 flex-1">
              <p class="font-bold text-ink-900 truncate">${name}</p>
              <p class="text-[11px] text-ink-500 truncate">${sub || 'Philippines'}</p>
            </div>
          </button>
        `;
      });

      container.innerHTML = html;
      box.classList.remove('hidden');
    }

    window.selectSuggestion = function(lat, lng, name, address) {
      updateMapPosition(lat, lng, 16, `✓ Selected: ${name}`);
      document.getElementById('mapSearchInput').value = name;
      
      const addrField = document.getElementById('fieldAddress');
      if (addrField && (!addrField.value || addrField.value.trim() === '')) {
        addrField.value = address || name;
      }

      hideSuggestions();
    };

    // Close suggestions on outside click
    document.addEventListener('click', (e) => {
      const box = document.getElementById('searchSuggestionsBox');
      const input = document.getElementById('mapSearchInput');
      if (box && input && !box.contains(e.target) && e.target !== input) {
        hideSuggestions();
      }
    });

    function executeGeocodeSearch(query, isAutocomplete = false) {
      if (!isAutocomplete) {
        showSearchStatus('🔍 Searching place / landmark...', false);
      }

      // Fast Photon Geocoder API with local coordinates bias towards Balingasag
      const photonUrl = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&lat=8.7455&lon=124.7745&limit=6`;

      fetch(photonUrl)
        .then(res => res.json())
        .then(data => {
          if (data && data.features && data.features.length > 0) {
            const list = data.features.map(f => {
              const props = f.properties || {};
              const coords = f.geometry ? f.geometry.coordinates : [124.7745, 8.7455];
              return {
                lat: coords[1],
                lng: coords[0],
                name: props.name || props.street || query,
                street: props.street,
                district: props.district || props.locality,
                city: props.city || props.town || props.county,
                state: props.state,
                osm_key: props.osm_key,
                osm_val: props.osm_value,
                type: props.type
              };
            });

            if (isAutocomplete) {
              renderSuggestions(list);
            } else {
              const top = list[0];
              updateMapPosition(top.lat, top.lng, 16, `✓ Found: ${top.name}`);
              hideSuggestions();
            }
          } else {
            // Fallback to OpenStreetMap Nominatim
            fallbackNominatim(query, isAutocomplete);
          }
        })
        .catch(() => {
          fallbackNominatim(query, isAutocomplete);
        });
    }

    function fallbackNominatim(query, isAutocomplete = false) {
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`)
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            const list = data.map(item => ({
              lat: parseFloat(item.lat),
              lng: parseFloat(item.lon),
              name: item.display_name.split(',')[0],
              street: item.display_name.split(',').slice(1, 3).join(','),
              type: item.type
            }));

            if (isAutocomplete) {
              renderSuggestions(list);
            } else {
              updateMapPosition(list[0].lat, list[0].lng, 16, `✓ Found: ${list[0].name}`);
              hideSuggestions();
            }
          } else {
            if (isAutocomplete) {
              renderSuggestions([]);
            } else {
              showSearchStatus('❌ Location not found. Try dragging pin or pasting Google Maps link.', true);
            }
          }
        })
        .catch(() => {
          showSearchStatus('⚠️ Search request failed. Please check internet connection.', true);
        });
    }

    window.handleMapSearch = function() {
      const input = document.getElementById('mapSearchInput').value.trim();
      if (!input) return;

      // 1. Raw coordinates (e.g. "8.7455, 124.7745" or "8.7455 124.7745")
      const coordMatch = input.match(/^(-?\d+(\.\d+)?)[,\s]+(-?\d+(\.\d+)?)$/);
      if (coordMatch) {
        const lat = parseFloat(coordMatch[1]);
        const lng = parseFloat(coordMatch[3]);
        updateMapPosition(lat, lng, 16, `📍 Set coordinates: ${lat.toFixed(5)}, ${lng.toFixed(5)}`);
        hideSuggestions();
        return;
      }

      // 2. Google Maps URL (@lat,lng or ?q=lat,lng)
      const gmapUrlMatch = input.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/) || input.match(/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/);
      if (gmapUrlMatch) {
        const lat = parseFloat(gmapUrlMatch[1]);
        const lng = parseFloat(gmapUrlMatch[2]);
        updateMapPosition(lat, lng, 17, `📍 Extracted from Google Maps: ${lat.toFixed(5)}, ${lng.toFixed(5)}`);
        hideSuggestions();
        return;
      }

      // 3. Place / Landmark search
      executeGeocodeSearch(input, false);
    };

    window.locateAdminGPS = function() {
      if (!navigator.geolocation) {
        showSearchStatus('❌ Geolocation is not supported by your browser.', true);
        return;
      }
      showSearchStatus('📡 Getting your GPS location...', false);
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lng = position.coords.longitude;
          updateMapPosition(lat, lng, 17, `📍 GPS Location detected (±${Math.round(position.coords.accuracy)}m accuracy)`);
        },
        (error) => {
          showSearchStatus(`❌ GPS Error: ${error.message}`, true);
        },
        { enableHighAccuracy: true, timeout: 10000 }
      );
    };

    function openPanel() {
      panelOverlay.classList.remove('hidden');
      panel.classList.remove('panel-enter');
      panel.classList.add('panel-open');
      setTimeout(() => {
        if (adminMap) adminMap.invalidateSize();
      }, 300);
    }

    function closePanel() {
      panelOverlay.classList.add('hidden');
      panel.classList.remove('panel-open');
      panel.classList.add('panel-enter');
    }

    if (openAddBtn) {
      openAddBtn.addEventListener('click', () => {
        document.getElementById('panelTitle').textContent = 'Add Destination';
        document.getElementById('editDestinationId').value = '';
        document.getElementById('destinationForm').reset();
        setCoordinates(8.7455, 124.7745);
        openPanel();
        setTimeout(() => initAdminPickerMap(8.7455, 124.7745), 200);
      });
    }

    if (closePanelBtn) closePanelBtn.addEventListener('click', closePanel);
    if (cancelBtn) cancelBtn.addEventListener('click', closePanel);
    if (panelOverlay) panelOverlay.addEventListener('click', closePanel);

    window.openEditDestinationModal = function(dest) {
      document.getElementById('panelTitle').textContent = 'Edit ' + dest.name;
      document.getElementById('editDestinationId').value = dest.id;
      document.getElementById('fieldName').value = dest.name || '';
      document.getElementById('fieldCategory').value = dest.category || 'other';
      document.getElementById('fieldFee').value = dest.entrance_fee || '';
      document.getElementById('fieldAddress').value = dest.address || '';
      document.getElementById('fieldShort').value = dest.short_description || '';
      document.getElementById('fieldFull').value = dest.description || '';
      document.getElementById('fieldOpenTime').value = dest.opening_time || '';
      document.getElementById('fieldCloseTime').value = dest.closing_time || '';
      document.getElementById('fieldContact').value = dest.contact_number || dest.contact_email || '';
      document.getElementById('fieldCoverUrl').value = dest.cover_image || '';

      const lat = dest.latitude ? Number(dest.latitude) : 8.7455;
      const lng = dest.longitude ? Number(dest.longitude) : 124.7745;
      setCoordinates(lat, lng);

      openPanel();
      setTimeout(() => initAdminPickerMap(lat, lng), 200);
    };

    window.saveDestinationForm = function() {
      const name = document.getElementById('fieldName').value.trim();
      const address = document.getElementById('fieldAddress').value.trim();
      const category = document.getElementById('fieldCategory').value;
      const editId = document.getElementById('editDestinationId').value;

      if (!name || !address) {
        alert('Please fill in the destination name and address.');
        return;
      }

      const payload = {
        name: name,
        category: category,
        address: address,
        short_description: document.getElementById('fieldShort').value.trim(),
        description: document.getElementById('fieldFull').value.trim(),
        entrance_fee: document.getElementById('fieldFee').value || 0,
        latitude: document.getElementById('fieldLatitude').value,
        longitude: document.getElementById('fieldLongitude').value,
        opening_time: document.getElementById('fieldOpenTime').value || null,
        closing_time: document.getElementById('fieldCloseTime').value || null,
        contact_number: document.getElementById('fieldContact').value.trim() || null,
        cover_image: document.getElementById('fieldCoverUrl').value.trim() || null,
        is_published: true
      };

      const url = editId ? `/admin/destinations/${editId}` : '/admin/destinations';
      const method = editId ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          window.location.reload();
        } else {
          alert(data.message || 'Validation error.');
        }
      })
      .catch(() => alert('Failed to save destination. Please check the inputs.'));
    };

    window.confirmDeleteDestination = function(id, name) {
      deleteId = id;
      document.getElementById('deleteTargetName').textContent = name;
      document.getElementById('deleteConfirmModal').classList.remove('hidden');
      document.getElementById('deleteConfirmModal').classList.add('flex');
    };

    window.closeDeleteModal = function() {
      document.getElementById('deleteConfirmModal').classList.add('hidden');
      document.getElementById('deleteConfirmModal').classList.remove('flex');
      deleteId = null;
    };

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
      confirmDeleteBtn.addEventListener('click', () => {
        if (!deleteId) return;

        fetch(`/admin/destinations/${deleteId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          window.location.reload();
        })
        .catch(() => alert('Failed to delete destination.'));
      });
    }
  </script>
@endpush
