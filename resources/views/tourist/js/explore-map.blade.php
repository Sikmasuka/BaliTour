<script>
document.addEventListener('DOMContentLoaded', function () {
  const mapElement = document.getElementById('exploreFullMap');
  if (!mapElement) return;

  const places = @json($mapSpotsData);
  let mapMarkers = {};
  let userMarker = null;
  let searchResultMarker = null;

  // Initialize modern map centered on Balingasag
  const map = L.map('exploreFullMap', {
    zoomControl: false,
    scrollWheelZoom: true
  }).setView([8.7455, 124.7745], 13);

  // Add zoom control bottom right
  L.control.zoom({ position: 'bottomright' }).addTo(map);

  // Modern Clean CartoDB Voyager Map Tiles & High-Res Esri Satellite Layer
  const streetTiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; CARTO &copy; OpenStreetMap',
    maxZoom: 19,
    subdomains: 'abcd'
  });

  const satelliteTiles = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri &mdash; Maxar, Earthstar Geographics',
    maxZoom: 19
  });

  // Default to Voyager Street view
  streetTiles.addTo(map);

  // Layer control
  const baseLayers = {
    "🗺️ Clean Map": streetTiles,
    "🛰️ Satellite": satelliteTiles
  };
  L.control.layers(baseLayers, null, { position: 'bottomright' }).addTo(map);

  // Create custom marker icons
  function createCustomPin(item) {
    const color = item.color || '#1B5E41';
    const emoji = item.emoji || '📍';
    return L.divIcon({
      className: 'custom-map-pin-container',
      html: `
        <div id="pin-${item.id}" class="custom-map-pin" 
             style="background:${color}; color:#ffffff; border:2.5px solid #ffffff; border-radius:50%; width:34px; height:34px; display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:bold;">
          ${emoji}
        </div>
      `,
      iconSize: [34, 34],
      iconAnchor: [17, 17],
      popupAnchor: [0, -18]
    });
  }

  // Populate map with pins
  if (places && places.length > 0) {
    const markerGroup = [];

    places.forEach(place => {
      if (place.latitude && place.longitude) {
        const marker = L.marker([place.latitude, place.longitude], {
          icon: createCustomPin(place)
        }).addTo(map);

        // Rich Popup Card
        const popupContent = `
          <div style="width: 230px; font-family: 'Inter', sans-serif;">
            <div style="position: relative; height: 110px; width: 100%; overflow: hidden; background: #E7EFEA;">
              <img src="${place.cover_image}" alt="${place.name}" style="width: 100%; height: 100%; object-fit: cover;">
              <span style="position: absolute; top: 6px; left: 6px; background: rgba(9,30,20,0.9); color: #DCEAE1; font-size: 9.5px; font-weight: bold; padding: 2px 6px; border-radius: 6px;">
                ${place.category_label}
              </span>
              <span style="position: absolute; bottom: 6px; right: 6px; background: rgba(9,30,20,0.9); color: #88B8A2; font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 6px;">
                ${place.entrance_fee}
              </span>
            </div>
            <div style="padding: 10px 12px; background: #FFFFFF;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 4px;">
                <h4 style="font-weight: bold; font-size: 13px; margin: 0; color: #091E14; line-height: 1.2;">${place.name}</h4>
                <span style="color: #C88A2E; font-weight: bold; font-size: 11px;">★ ${place.average_rating}</span>
              </div>
              <p style="margin: 3px 0 8px 0; color: #4D6D5E; font-size: 10.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">📍 ${place.address}</p>
              <a href="/destinations/${place.slug}" 
                 style="display: block; width: 100%; text-align: center; background: #1B5E41; color: #FFFFFF; padding: 6px 0; border-radius: 8px; font-size: 11px; font-weight: bold; text-decoration: none; box-shadow: 0 1px 3px rgba(9,30,20,0.2);">
                Explore Details & Trail ↗
              </a>
            </div>
          </div>
        `;

        marker.bindPopup(popupContent);
        mapMarkers[place.id] = marker;
        markerGroup.push(marker);

        // Marker click synchronizes with card highlight & open drawer if closed
        marker.on('click', () => {
          openDrawer();
          highlightCard(place.id);
        });
      }
    });

    // Fit map bounds to show all pins if multiple
    if (markerGroup.length > 1) {
      const group = new L.featureGroup(markerGroup);
      map.fitBounds(group.getBounds().pad(0.12));
    }
  }

  // Highlight Card when pin is clicked
  function highlightCard(id) {
    document.querySelectorAll('.destination-card').forEach(c => {
      c.classList.remove('ring-2', 'ring-forest-600', 'bg-forest-50');
    });
    const targetCard = document.getElementById(`card-${id}`);
    if (targetCard) {
      targetCard.classList.add('ring-2', 'ring-forest-600', 'bg-forest-50');
      targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
  }

  // Fly to destination from card button
  window.flyToPlace = function (id, lat, lng) {
    if (!lat || !lng) return;
    map.flyTo([lat, lng], 16, { animate: true, duration: 1.2 });
    
    setTimeout(() => {
      if (mapMarkers[id]) {
        mapMarkers[id].openPopup();
      }
    }, 1200);

    highlightCard(id);
  };

  // Recenter to Balingasag
  const recenterBtn = document.getElementById('recenterMapBtn');
  if (recenterBtn) {
    recenterBtn.addEventListener('click', () => {
      map.flyTo([8.7455, 124.7745], 13, { animate: true, duration: 1 });
    });
  }

  // Locate User GPS
  const locateBtn = document.getElementById('locateUserBtn');
  if (locateBtn) {
    locateBtn.addEventListener('click', () => {
      if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser.');
        return;
      }

      locateBtn.innerHTML = '<span>Locating...</span>';

      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const userLat = pos.coords.latitude;
          const userLng = pos.coords.longitude;

          if (userMarker) map.removeLayer(userMarker);

          const userPin = L.divIcon({
            className: 'user-gps-pin',
            html: `<div style="background:#1B5E41; color:white; border:3px solid white; border-radius:50%; width:22px; height:22px; box-shadow:0 0 0 6px rgba(27,94,65,0.3); display:flex; align-items:center; justify-content:center; font-size:10px;">📍</div>`,
            iconSize: [22, 22],
            iconAnchor: [11, 11]
          });

          userMarker = L.marker([userLat, userLng], { icon: userPin }).addTo(map);
          userMarker.bindPopup('<b style="font-family:Inter,sans-serif;">📍 Your Current Location</b>').openPopup();

          map.flyTo([userLat, userLng], 15, { animate: true, duration: 1.2 });
          locateBtn.innerHTML = '<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg><span class="hidden sm:inline">My GPS</span>';
        },
        () => {
          alert('Could not determine your GPS location. Please allow location permissions in your browser.');
          locateBtn.innerHTML = '<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg><span class="hidden sm:inline">My GPS</span>';
        }
      );
    });
  }

  // Fullscreen Toggle
  const fullscreenBtn = document.getElementById('fullscreenToggleBtn');
  const explorerElem = document.getElementById('fullMapExplorer');
  if (fullscreenBtn && explorerElem) {
    fullscreenBtn.addEventListener('click', () => {
      if (!document.fullscreenElement) {
        explorerElem.requestFullscreen().then(() => {
          setTimeout(() => map.invalidateSize(), 200);
        }).catch(err => console.error(err));
      } else {
        document.exitFullscreen().then(() => {
          setTimeout(() => map.invalidateSize(), 200);
        }).catch(err => console.error(err));
      }
    });
  }

  // Drawer Toggle (Slide in / Slide out)
  const placesDrawer = document.getElementById('placesDrawer');
  const toggleDrawerBtn = document.getElementById('toggleDrawerBtn');
  const toggleDrawerIcon = document.getElementById('toggleDrawerIcon');
  const toggleDrawerText = document.getElementById('toggleDrawerText');
  const closeDrawerInnerBtn = document.getElementById('closeDrawerInnerBtn');

  function openDrawer() {
    if (!placesDrawer) return;
    placesDrawer.classList.remove('-translate-x-[420px]', 'opacity-0', 'pointer-events-none');
    if (toggleDrawerIcon) toggleDrawerIcon.textContent = '◀';
    if (toggleDrawerText) toggleDrawerText.textContent = `Hide List`;
  }

  function closeDrawer() {
    if (!placesDrawer) return;
    placesDrawer.classList.add('-translate-x-[420px]', 'opacity-0', 'pointer-events-none');
    if (toggleDrawerIcon) toggleDrawerIcon.textContent = '▶';
    if (toggleDrawerText) toggleDrawerText.textContent = `Places (${places.length})`;
  }

  if (toggleDrawerBtn && placesDrawer) {
    toggleDrawerBtn.addEventListener('click', () => {
      const isHidden = placesDrawer.classList.contains('-translate-x-[420px]');
      if (isHidden) {
        openDrawer();
      } else {
        closeDrawer();
      }
    });
  }

  if (closeDrawerInnerBtn) {
    closeDrawerInnerBtn.addEventListener('click', closeDrawer);
  }

  // Mobile auto-collapse on narrow screens so map is immediately visible
  if (window.innerWidth < 768) {
    closeDrawer();
  }

  // --- SMART GOOGLE-MAPS LIKE LIVE PLACE SEARCH & GEOCODER ---
  const liveSearch = document.getElementById('liveSearchInput');
  const clearSearchBtn = document.getElementById('clearSearchBtn');
  const dropdownBox = document.getElementById('touristSearchDropdown');
  const dropdownContent = document.getElementById('touristSearchDropdownContent');
  const countLabel = document.getElementById('spotCountLabel');
  let searchTimer = null;

  function getPlaceIcon(type = '', osmKey = '', osmVal = '') {
    const combined = `${type} ${osmKey} ${osmVal}`.toLowerCase();
    if (combined.includes('school') || combined.includes('college') || combined.includes('university')) return '🏫';
    if (combined.includes('cafe') || combined.includes('coffee')) return '☕';
    if (combined.includes('restaurant') || combined.includes('food') || combined.includes('fast_food')) return '🍽️';
    if (combined.includes('hotel') || combined.includes('resort') || combined.includes('guest_house')) return '🏨';
    if (combined.includes('beach') || combined.includes('seashore') || combined.includes('coast')) return '🏖️';
    if (combined.includes('church') || combined.includes('cathedral') || combined.includes('place_of_worship')) return '⛪';
    if (combined.includes('falls') || combined.includes('nature') || combined.includes('park')) return '🌿';
    if (combined.includes('gym') || combined.includes('sports')) return '💪';
    if (combined.includes('market') || combined.includes('mall') || combined.includes('shop')) return '🛍️';
    return '📍';
  }

  function hideTouristDropdown() {
    if (dropdownBox) dropdownBox.classList.add('hidden');
  }

  // Focus on searched place (either registered spot or OSM live spot)
  window.selectTouristPlace = function (lat, lng, name, address, isRegistered = false, destId = null) {
    hideTouristDropdown();
    if (clearSearchBtn) clearSearchBtn.classList.remove('hidden');

    if (isRegistered && destId && mapMarkers[destId]) {
      openDrawer();
      highlightCard(destId);
      map.flyTo([lat, lng], 16, { animate: true, duration: 1.2 });
      setTimeout(() => mapMarkers[destId].openPopup(), 1200);
      return;
    }

    // If real-world place (e.g. St. Rita's College of Balingasag)
    if (searchResultMarker) {
      map.removeLayer(searchResultMarker);
    }

    const searchPin = L.divIcon({
      className: 'search-result-pin',
      html: `
        <div style="background:#0F52BA; color:#ffffff; border:3px solid #ffffff; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:bold; box-shadow:0 8px 20px rgba(15,82,186,0.5); animation: bounce 1s infinite alternate;">
          📍
        </div>
      `,
      iconSize: [36, 36],
      iconAnchor: [18, 18],
      popupAnchor: [0, -18]
    });

    searchResultMarker = L.marker([lat, lng], { icon: searchPin }).addTo(map);

    const popupHtml = `
      <div style="width: 240px; padding: 12px; font-family: 'Inter', sans-serif;">
        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
          <span style="font-size: 14px;">📍</span>
          <span style="font-size: 10px; font-weight: bold; text-transform: uppercase; color: #0F52BA; letter-spacing: 0.05em;">Live Location</span>
        </div>
        <h3 style="font-weight: bold; font-size: 13.5px; margin: 0 0 4px 0; color: #091E14; line-height: 1.3;">${name}</h3>
        <p style="margin: 0 0 10px 0; color: #4D6D5E; font-size: 11px; line-height: 1.4;">${address || 'Balingasag, Misamis Oriental'}</p>
        <div style="display: flex; gap: 6px;">
          <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank" rel="noopener noreferrer"
             style="display: inline-block; flex: 1; text-align: center; background: #0F52BA; color: #ffffff; padding: 6px 0; border-radius: 8px; font-size: 11px; font-weight: bold; text-decoration: none; box-shadow: 0 2px 6px rgba(15,82,186,0.3);">
            Open in Google Maps ↗
          </a>
        </div>
      </div>
    `;

    searchResultMarker.bindPopup(popupHtml).openPopup();
    map.flyTo([lat, lng], 17, { animate: true, duration: 1.2 });
  };

  function renderTouristSuggestions(query, registeredMatches, osmMatches) {
    if (!dropdownBox || !dropdownContent) return;

    if (registeredMatches.length === 0 && osmMatches.length === 0) {
      dropdownContent.innerHTML = `
        <div class="p-3.5 text-center text-ink-500">
          <p class="font-medium">No places found for "${query}".</p>
          <p class="text-[10px] mt-0.5">Try searching town names, streets, or schools.</p>
        </div>
      `;
      dropdownBox.classList.remove('hidden');
      return;
    }

    let html = '';

    // 1. Registered Destinations
    if (registeredMatches.length > 0) {
      html += `<div class="px-3 py-1.5 bg-mineral-100/70 text-[10px] font-bold uppercase tracking-wider text-forest-900">BaliTour Verified Spots</div>`;
      registeredMatches.forEach(dest => {
        html += `
          <button type="button" 
            onclick="selectTouristPlace(${dest.latitude}, ${dest.longitude}, '${dest.name.replace(/'/g, "\\'")}', '${dest.address.replace(/'/g, "\\'")}', true, ${dest.id})"
            class="w-full text-left px-3.5 py-2.5 hover:bg-forest-50 flex items-start gap-2.5 transition cursor-pointer">
            <span class="text-base shrink-0 mt-0.5">🌟</span>
            <div class="min-w-0 flex-1">
              <p class="font-bold text-forest-950 truncate">${dest.name}</p>
              <p class="text-[10.5px] text-ink-600 truncate">${dest.address}</p>
            </div>
            <span class="text-[10px] font-bold text-forest-700 shrink-0 self-center">View ↗</span>
          </button>
        `;
      });
    }

    // 2. Real-world OpenStreetMap Places / Schools / Cafes (via Photon)
    if (osmMatches.length > 0) {
      html += `<div class="px-3 py-1.5 bg-mineral-100/70 text-[10px] font-bold uppercase tracking-wider text-ink-600">Landmarks & Establishments</div>`;
      osmMatches.forEach(p => {
        const icon = getPlaceIcon(p.type, p.osm_key, p.osm_val);
        const name = p.name || p.street || 'Location';
        const sub = [p.street, p.district, p.city, p.state].filter(Boolean).join(', ');

        html += `
          <button type="button" 
            onclick="selectTouristPlace(${p.lat}, ${p.lng}, '${name.replace(/'/g, "\\'")}', '${sub.replace(/'/g, "\\'")}', false, null)"
            class="w-full text-left px-3.5 py-2.5 hover:bg-mineral-100/80 flex items-start gap-2.5 transition cursor-pointer">
            <span class="text-base shrink-0 mt-0.5">${icon}</span>
            <div class="min-w-0 flex-1">
              <p class="font-bold text-ink-950 truncate">${name}</p>
              <p class="text-[10.5px] text-ink-500 truncate">${sub || 'Misamis Oriental, Philippines'}</p>
            </div>
            <span class="text-[10px] font-medium text-ink-400 shrink-0 self-center">Fly 📍</span>
          </button>
        `;
      });
    }

    dropdownContent.innerHTML = html;
    dropdownBox.classList.remove('hidden');
  }

  function queryTouristPlaces(query) {
    const q = query.trim().toLowerCase();

    // 1. Check local registered destinations
    const registeredMatches = places.filter(p => {
      return (p.name && p.name.toLowerCase().includes(q)) || 
             (p.address && p.address.toLowerCase().includes(q)) ||
             (p.category && p.category.toLowerCase().includes(q));
    });

    // 2. Live query Photon API (biased to Balingasag coordinates)
    const photonUrl = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&lat=8.7455&lon=124.7745&limit=5`;

    fetch(photonUrl)
      .then(res => res.json())
      .then(data => {
        let osmMatches = [];
        if (data && data.features) {
          osmMatches = data.features.map(f => {
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
        }
        renderTouristSuggestions(query, registeredMatches, osmMatches);
      })
      .catch(() => {
        renderTouristSuggestions(query, registeredMatches, []);
      });
  }

  if (liveSearch) {
    liveSearch.addEventListener('input', (e) => {
      const q = e.target.value.trim();

      if (clearSearchBtn) {
        if (q.length > 0) clearSearchBtn.classList.remove('hidden');
        else clearSearchBtn.classList.add('hidden');
      }

      // Filter drawer cards locally
      let visibleCount = 0;
      document.querySelectorAll('.destination-card').forEach(card => {
        const name = card.dataset.name || '';
        const address = card.dataset.address || '';
        const id = card.dataset.id;
        const matches = name.includes(q.toLowerCase()) || address.includes(q.toLowerCase());

        if (matches) {
          card.style.display = 'flex';
          visibleCount++;
          if (mapMarkers[id]) mapMarkers[id].setOpacity(1);
        } else {
          card.style.display = 'none';
          if (mapMarkers[id]) mapMarkers[id].setOpacity(0.15);
        }
      });

      if (countLabel) {
        countLabel.textContent = `${visibleCount} spots`;
      }

      clearTimeout(searchTimer);
      if (q.length >= 2) {
        searchTimer = setTimeout(() => {
          queryTouristPlaces(q);
        }, 300);
      } else {
        hideTouristDropdown();
      }
    });

    liveSearch.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const firstBtn = dropdownContent ? dropdownContent.querySelector('button') : null;
        if (firstBtn) {
          firstBtn.click();
        } else {
          queryTouristPlaces(liveSearch.value);
        }
      }
    });
  }

  if (clearSearchBtn) {
    clearSearchBtn.addEventListener('click', () => {
      liveSearch.value = '';
      clearSearchBtn.classList.add('hidden');
      hideTouristDropdown();
      if (searchResultMarker) {
        map.removeLayer(searchResultMarker);
        searchResultMarker = null;
      }
      document.querySelectorAll('.destination-card').forEach(card => {
        card.style.display = 'flex';
        const id = card.dataset.id;
        if (mapMarkers[id]) mapMarkers[id].setOpacity(1);
      });
      if (countLabel) {
        countLabel.textContent = `${places.length} spots`;
      }
    });
  }

  // Hide dropdown on outside click
  document.addEventListener('click', (e) => {
    if (dropdownBox && liveSearch && !dropdownBox.contains(e.target) && e.target !== liveSearch) {
      hideTouristDropdown();
    }
  });

  // Resize listener
  window.addEventListener('resize', () => {
    setTimeout(() => map.invalidateSize(), 200);
  });
});
</script>
