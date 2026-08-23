<!-- ==================== ABOUT BALINGASAG (WARM OFF-WHITE SECTION) ==================== -->
<section id="about" class="py-12 bg-[#FAFBF7] border-b border-[#D4D9CB] overflow-hidden">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
      
      <!-- Text & Highlights -->
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

      <!-- Heritage Photo Stack Gallery -->
      <div class="md:col-span-5 relative reveal-on-scroll delay-200">
        <div class="relative mx-auto w-full max-w-[440px] select-none" id="heritageStackGallery">
          
          <!-- Top bar with counter & hint -->
          <div class="mb-3 flex items-center justify-between px-1">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#E8F5E9] border border-[#C8E6C9] px-2.5 py-1 text-[11px] font-bold text-[#0E4E31] shadow-xs">
              <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="3" rx="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/><circle cx="9" cy="9" r="2"/>
              </svg>
              <span>Heritage Stack</span>
              <span id="heritageCurrentIndex" class="ml-1 rounded-md bg-[#0E4E31] px-1.5 py-0.5 text-[10px] font-bold text-white">1 / 5</span>
            </span>
            <span class="text-[11px] text-[#4A5D4E] font-medium hidden sm:inline-flex items-center gap-1 opacity-90">
              <span>Click card or arrows to shuffle</span>
              <span class="text-amber-600">✦</span>
            </span>
          </div>

          <!-- Stack Card Deck Container -->
          <div class="relative h-[250px] sm:h-[280px] w-full cursor-pointer heritage-stack-container" id="heritageCardDeck" role="region" aria-label="Balingasag Heritage Photo Gallery" tabindex="0">
            @php
              $heritageImages = [
                [
                  'src' => 'images/heritage/473270785_1584910272230645_2282358448381981731_n.jpg',
                  'title' => 'Balingasag Heritage Landmark',
                  'desc' => 'Preserved colonial architecture & historic charm'
                ],
                [
                  'src' => 'images/heritage/472572341_1584910218897317_3528288469187220518_n.jpg',
                  'title' => 'Spanish-Era Architecture',
                  'desc' => 'Timeless craftsmanship passed down through generations'
                ],
                [
                  'src' => 'images/heritage/472722735_1584910515563954_8556734267871241298_n.jpg',
                  'title' => 'Historic Town Center',
                  'desc' => 'The vibrant cultural heart of Balingasag'
                ],
                [
                  'src' => 'images/heritage/472728908_1584910645563941_293914223041550857_n.jpg',
                  'title' => 'Ancestral & Cultural Roots',
                  'desc' => 'Honoring historical memories and local identity'
                ],
                [
                  'src' => 'images/heritage/473321324_1584910602230612_5383627153131279115_n.jpg',
                  'title' => 'Cultural Heritage & Community',
                  'desc' => 'Where traditions and modern coastal life blend'
                ],
              ];
            @endphp

            @foreach($heritageImages as $index => $img)
              <div class="heritage-stack-card absolute inset-0 rounded-2xl overflow-hidden border-2 border-white bg-stone-900 shadow-lg group select-none"
                   data-index="{{ $index }}"
                   data-title="{{ $img['title'] }}"
                   data-desc="{{ $img['desc'] }}">
                <img src="{{ asset($img['src']) }}" alt="{{ $img['title'] }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
                <div class="absolute bottom-0 inset-x-0 p-3.5 sm:p-4 text-white pointer-events-none">
                  <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-[#0E4E31]/90 backdrop-blur-xs text-[10px] font-bold uppercase tracking-wider text-emerald-200 mb-1">
                    Photo {{ $index + 1 }} of {{ count($heritageImages) }}
                  </div>
                  <h3 class="text-sm sm:text-base font-bold text-white leading-snug drop-shadow-xs">{{ $img['title'] }}</h3>
                  <p class="text-[11px] sm:text-xs text-white/85 line-clamp-1 mt-0.5 drop-shadow-xs">{{ $img['desc'] }}</p>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Controls: Prev/Next & Dots -->
          <div class="mt-4 flex items-center justify-between px-1">
            <!-- Interactive Dots -->
            <div class="flex items-center gap-1.5" id="heritageDots" aria-label="Heritage gallery navigation dots">
              @foreach($heritageImages as $index => $img)
                <button type="button" class="heritage-dot h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-6 bg-[#0E4E31]' : 'w-2 bg-[#D4D9CB] hover:bg-[#8F9F8B]' }}" data-dot="{{ $index }}" aria-label="Go to image {{ $index + 1 }}"></button>
              @endforeach
            </div>

            <!-- Navigation Arrow Buttons -->
            <div class="flex items-center gap-2">
              <button type="button" id="heritagePrevBtn" class="flex h-8 w-8 items-center justify-center rounded-xl border border-[#D4D9CB] bg-white hover:bg-[#FAFBF7] hover:border-[#0E4E31] text-[#0B291E] shadow-xs transition-all active:scale-95 cursor-pointer" aria-label="Previous heritage photo">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
              </button>
              <button type="button" id="heritageNextBtn" class="flex h-8 w-8 items-center justify-center rounded-xl border border-[#D4D9CB] bg-white hover:bg-[#FAFBF7] hover:border-[#0E4E31] text-[#0B291E] shadow-xs transition-all active:scale-95 cursor-pointer" aria-label="Next heritage photo">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
