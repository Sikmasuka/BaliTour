<!-- ==================== KEY DESTINATIONS (HORIZONTAL KINETIC DRIFT WALL) ==================== -->
<section id="destinations" class="py-14 bg-[#061A13] text-white relative overflow-hidden">
  
  <!-- Subtle Ambient Glow Lights -->
  <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[280px] bg-emerald-600/15 blur-[120px] pointer-events-none rounded-full"></div>
  <div class="absolute -bottom-24 right-10 w-[400px] h-[250px] bg-amber-500/10 blur-[100px] pointer-events-none rounded-full"></div>

  <div class="mx-auto max-w-6xl px-4 sm:px-6 relative z-10 mb-6">
    
    <!-- Section Headline & Indicator -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 reveal-on-scroll">
      <div>
        <div class="inline-flex items-center gap-1.5 rounded-lg bg-[#0B291E] border border-emerald-500/30 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-300 mb-2 shadow-xs">
          <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
          </span>
          <span>Kinetic Destination Showcase</span>
        </div>
        <h2 class="font-serif text-2xl sm:text-4xl font-normal text-white tracking-tight">
          Top Places & Attractions in Balingasag
        </h2>
      </div>
      
      <div class="flex items-center gap-2 text-xs text-[#A2B3A6]">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 px-3 py-1 text-[11px] text-[#E2E8DF]">
          <svg class="h-3.5 w-3.5 text-emerald-400 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          <span>Hover any destination to inspect · Click to explore</span>
        </span>
      </div>
    </div>

  </div>

  @php
    $destinationsList = [
      // Row 1
      [
        'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
        'title' => 'Cameo (Mantalingo) Island',
        'category' => 'Island & Coral Reef',
        'rating' => '4.9',
        'tag' => 'Macajalar Bay'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=600&q=80',
        'title' => 'Kabatanga Falls',
        'category' => 'Waterfalls & Springs',
        'rating' => '4.9',
        'tag' => 'Upland Eco-Park'
      ],
      [
        'image' => asset('images/heritage/473270785_1584910272230645_2282358448381981731_n.jpg'),
        'title' => 'Balingasag Heritage Site',
        'category' => 'Colonial Landmark',
        'rating' => '4.8',
        'tag' => 'Poblacion'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1548625361-195fe579b5c3?auto=format&fit=crop&w=600&q=80',
        'title' => 'San Roque Parish Church',
        'category' => 'Spanish Stone Church',
        'rating' => '4.8',
        'tag' => 'Century-Old'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=600&q=80',
        'title' => 'Balingasag Baywalk',
        'category' => 'Sunset Promenade',
        'rating' => '4.8',
        'tag' => 'Seafood & Streetfood'
      ],

      // Row 2
      [
        'image' => asset('images/heritage/472572341_1584910218897317_3528288469187220518_n.jpg'),
        'title' => 'Vega Ancestral House',
        'category' => 'Preserved Architecture',
        'rating' => '4.7',
        'tag' => 'Poblacion'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=80',
        'title' => 'Mount Balatukan Ridge',
        'category' => 'Eco-Mountain Trek',
        'rating' => '4.9',
        'tag' => 'Highlands'
      ],
      [
        'image' => asset('images/heritage/472722735_1584910515563954_8556734267871241298_n.jpg'),
        'title' => 'Historic Town Center',
        'category' => 'Plaza Complex',
        'rating' => '4.6',
        'tag' => 'Community Hub'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
        'title' => 'Blanco Water Springs',
        'category' => 'Natural Fresh Springs',
        'rating' => '4.7',
        'tag' => 'Cold Spring Pool'
      ],
      [
        'image' => asset('images/heritage/472728908_1584910645563941_293914223041550857_n.jpg'),
        'title' => 'Ancestral Memory Hall',
        'category' => 'Traditions & Roots',
        'rating' => '4.8',
        'tag' => 'Culture'
      ],

      // Row 3
      [
        'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?auto=format&fit=crop&w=600&q=80',
        'title' => 'Hermano Marine Reserve',
        'category' => 'Marine Protected Sanctuary',
        'rating' => '4.9',
        'tag' => 'Coral Garden'
      ],
      [
        'image' => asset('images/heritage/473321324_1584910602230612_5383627153131279115_n.jpg'),
        'title' => 'San Roque Fluvial Harbor',
        'category' => 'Annual Fiesta Procession',
        'rating' => '4.8',
        'tag' => 'August 16'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=600&q=80',
        'title' => 'Balatukan Canopy Viewdeck',
        'category' => 'Scenic Mountain Overlook',
        'rating' => '4.9',
        'tag' => 'Cloud Forest'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=600&q=80',
        'title' => 'Macajalar Night Boardwalk',
        'category' => 'Seaside Night Market',
        'rating' => '4.7',
        'tag' => 'BBQ & Bibingka'
      ],
      [
        'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=600&q=80',
        'title' => 'Kabatanga Forest Trail',
        'category' => 'Trekking & Birding',
        'rating' => '4.8',
        'tag' => 'Nature Hike'
      ],
    ];

    $rows = array_chunk($destinationsList, 5);
  @endphp

  <!-- ==================== HORIZONTAL KINETIC WALL ==================== -->
  <div class="relative w-full overflow-hidden space-y-4 py-2 horizontal-drift-mask" id="horizontalDriftContainer">
    
    @foreach($rows as $rowIndex => $rowItems)
      @php
        $direction = $rowIndex % 2 === 0 ? 'left' : 'right';
        $baseSpeed = $rowIndex === 1 ? 26 : ($rowIndex === 2 ? 32 : 28);
      @endphp

      <div class="horizontal-drift-row relative flex overflow-hidden select-none" 
           data-row-index="{{ $rowIndex }}" 
           data-direction="{{ $direction }}" 
           data-speed="{{ $baseSpeed }}">
        
        <div class="horizontal-drift-track flex gap-4 will-change-transform">
          {{-- 2 duplicate sequences for seamless horizontal looping --}}
          @for($copy = 0; $copy < 2; $copy++)
            @foreach($rowItems as $itemIndex => $item)
              <div class="horizontal-drift-tile open-modal group relative shrink-0 rounded-2xl overflow-hidden border border-white/15 bg-[#0B291E] shadow-md transition-all duration-300 hover:border-emerald-400 hover:shadow-2xl cursor-pointer"
                   role="button"
                   tabindex="0"
                   aria-label="{{ $item['title'] }} · {{ $item['category'] }}">
                
                <!-- Tile Image -->
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                
                <!-- Gradient Vignette Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent transition-opacity duration-300 group-hover:opacity-85 pointer-events-none"></div>

                <!-- Rich Tile Caption & Info -->
                <div class="absolute inset-0 p-3.5 flex flex-col justify-between pointer-events-none">
                  
                  <!-- Top Badges -->
                  <div class="flex items-center justify-between gap-1">
                    <span class="inline-flex items-center rounded-md bg-[#0B291E]/90 border border-emerald-400/30 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-emerald-300 backdrop-blur-xs">
                      {{ $item['tag'] }}
                    </span>
                    <span class="inline-flex items-center gap-1 rounded-md bg-black/60 px-1.5 py-0.5 text-[10px] font-bold text-amber-300 backdrop-blur-xs">
                      <svg class="h-3 w-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <span>{{ $item['rating'] }}</span>
                    </span>
                  </div>

                  <!-- Bottom Title & Category -->
                  <div>
                    <h3 class="font-serif text-sm font-bold text-white leading-snug drop-shadow-xs group-hover:text-emerald-300 transition-colors line-clamp-1">
                      {{ $item['title'] }}
                    </h3>
                    <p class="text-[11px] text-[#C5D3C8] line-clamp-1 mt-0.5 opacity-90 drop-shadow-xs">
                      {{ $item['category'] }}
                    </p>
                  </div>

                </div>

              </div>
            @endforeach
          @endfor
        </div>

      </div>
    @endforeach

  </div>

  <!-- Bottom Featured Destination Quick Tags -->
  <div class="mx-auto max-w-6xl px-4 sm:px-6 relative z-10 pt-6">
    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs">
      <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-400 mr-2">Quick Access:</span>
      
      <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/15 px-3 py-1.5 text-xs text-white backdrop-blur-md transition-all cursor-pointer">
        <span>🏝️ Cameo Coral Islet</span>
      </button>
      <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/15 px-3 py-1.5 text-xs text-white backdrop-blur-md transition-all cursor-pointer">
        <span>🌊 Kabatanga Falls</span>
      </button>
      <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/15 px-3 py-1.5 text-xs text-white backdrop-blur-md transition-all cursor-pointer">
        <span>⛪ San Roque 1800s Church</span>
      </button>
      <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/15 px-3 py-1.5 text-xs text-white backdrop-blur-md transition-all cursor-pointer">
        <span>🌅 Balingasag Baywalk</span>
      </button>
      <button type="button" class="open-modal inline-flex items-center gap-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/15 px-3 py-1.5 text-xs text-white backdrop-blur-md transition-all cursor-pointer">
        <span>🏔️ Mount Balatukan Ridge</span>
      </button>
    </div>
  </div>

</section>
