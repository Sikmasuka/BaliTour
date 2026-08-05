@extends('user.layout')

@section('title', 'Explore Places')
@section('page-subtitle', 'Explore Places')
@section('explore-places-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Discover</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Explore Balingasag</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Browse featured places and visitor favorites from the Balingasag tourism gallery, complete with reviews, details, and quick actions.</p>
  </section>

  <section class="mb-12">
    <div class="grid gap-8 lg:grid-cols-[1.4fr_0.95fr]">
      <div class="relative overflow-hidden rounded-[2.5rem] bg-white shadow-2xl">
        <div class="relative h-[36rem] overflow-hidden">
          <img id="heroPreviewImage" class="h-full w-full object-cover transition duration-500" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=80" alt="Featured destination">
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
          <div class="absolute inset-x-0 bottom-0 p-8 text-cream-50">
            <span id="heroPreviewCategory" class="inline-flex rounded-full bg-forest-900/80 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-cream-100">Nature</span>
            <h2 id="heroPreviewTitle" class="mt-6 max-w-3xl text-4xl font-semibold leading-tight sm:text-5xl">Kabatanga Falls</h2>
            <p id="heroPreviewDescription" class="mt-4 max-w-2xl text-sm leading-relaxed text-cream-100/90">A lush waterfall with trails, swimming pools, and quiet picnic areas just outside Balingasag.</p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
              <button id="heroPreviewBook" type="button" class="inline-flex items-center justify-center rounded-full bg-cream-50 px-6 py-3 text-sm font-semibold text-forest-900 transition hover:bg-white">Add to travel list</button>
              <button id="heroPreviewSave" type="button" class="inline-flex items-center justify-center rounded-full border border-cream-200 bg-white/10 px-6 py-3 text-sm font-semibold text-cream-100 transition hover:bg-white/20">Save</button>
              <button id="heroPreviewReview" type="button" class="inline-flex items-center justify-center rounded-full border border-cream-200 bg-white/10 px-6 py-3 text-sm font-semibold text-cream-100 transition hover:bg-white/20">Read review</button>
            </div>
            <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-cream-100/80">
              <span class="inline-flex items-center gap-2 rounded-full bg-black/30 px-3 py-2">4.9 ★</span>
              <span class="inline-flex items-center gap-2 rounded-full bg-black/30 px-3 py-2">Balingasag, Philippines</span>
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="rounded-[2.5rem] border border-cream-200/40 bg-white/95 p-6 shadow-sm">
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-500">Featured Places</p>
          <h2 class="mt-4 text-2xl font-semibold text-ink-950">Select a destination to preview.</h2>
          <p class="mt-3 text-sm leading-relaxed text-ink-600">Each destination includes a top image, review summary, and quick add/save controls.</p>
        </div>

        <div class="grid gap-4">
          <button type="button" data-index="0" class="place-card group flex items-center gap-4 rounded-[2rem] border border-cream-200/40 bg-white px-5 py-4 text-left transition hover:shadow-lg hover:border-forest-200">
            <span class="inline-flex h-20 w-20 overflow-hidden rounded-full border border-cream-200 bg-slate-100">
              <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80" alt="Kabatanga Falls">
            </span>
            <span class="min-w-0">
              <span class="block text-sm uppercase tracking-[0.24em] text-forest-900/70">Kabatanga Falls</span>
              <p class="mt-1 text-sm font-semibold text-ink-950">Waterfall Escape</p>
              <p class="mt-2 text-xs text-ink-600">Refreshing trails, pools, and forest walks.</p>
            </span>
          </button>

          <button type="button" data-index="1" class="place-card group flex items-center gap-4 rounded-[2rem] border border-cream-200/40 bg-white px-5 py-4 text-left transition hover:shadow-lg hover:border-forest-200">
            <span class="inline-flex h-20 w-20 overflow-hidden rounded-full border border-cream-200 bg-slate-100">
              <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1200&q=80" alt="San Roque Parish Church">
            </span>
            <span class="min-w-0">
              <span class="block text-sm uppercase tracking-[0.24em] text-forest-900/70">San Roque Parish Church</span>
              <p class="mt-1 text-sm font-semibold text-ink-950">Heritage Landmark</p>
              <p class="mt-2 text-xs text-ink-600">Historic architecture with local festivals and art.</p>
            </span>
          </button>

          <button type="button" data-index="2" class="place-card group flex items-center gap-4 rounded-[2rem] border border-cream-200/40 bg-white px-5 py-4 text-left transition hover:shadow-lg hover:border-forest-200">
            <span class="inline-flex h-20 w-20 overflow-hidden rounded-full border border-cream-200 bg-slate-100">
              <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1200&q=80" alt="Macajalar Bay Boardwalk">
            </span>
            <span class="min-w-0">
              <span class="block text-sm uppercase tracking-[0.24em] text-forest-900/70">Macajalar Bay Boardwalk</span>
              <p class="mt-1 text-sm font-semibold text-ink-950">Seaside Stroll</p>
              <p class="mt-2 text-xs text-ink-600">Sunset views, local snacks, and ocean breeze.</p>
            </span>
          </button>

          <button type="button" data-index="3" class="place-card group flex items-center gap-4 rounded-[2rem] border border-cream-200/40 bg-white px-5 py-4 text-left transition hover:shadow-lg hover:border-forest-200">
            <span class="inline-flex h-20 w-20 overflow-hidden rounded-full border border-cream-200 bg-slate-100">
              <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80" alt="Cameo Island">
            </span>
            <span class="min-w-0">
              <span class="block text-sm uppercase tracking-[0.24em] text-forest-900/70">Cameo Island</span>
              <p class="mt-1 text-sm font-semibold text-ink-950">Island Getaway</p>
              <p class="mt-2 text-xs text-ink-600">Crystal waters and easy beach-side adventure.</p>
            </span>
          </button>
        </div>
      </div>
    </div>
  </section>

  <div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-auto bg-black/60 p-6">
    <div class="mx-auto w-full max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-cream-200">
      <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr]">
        <div class="relative flex items-center justify-center bg-ink-950 p-6">
          <img id="modalImage" class="max-h-[80vh] w-full max-w-full rounded-[1.75rem] object-contain" src="" alt="Enlarged destination photo">
        </div>
        <div class="flex flex-col justify-between p-8">
          <div>
            <p id="modalCategory" class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-400">Review</p>
            <h3 id="modalTitle" class="mt-2 text-3xl font-semibold text-forest-900">Destination review</h3>
            <p id="modalMeta" class="mt-3 text-sm text-ink-600">Tap outside or press close when done.</p>
            <div class="mt-6 rounded-3xl bg-cream-50 p-6 text-sm leading-relaxed text-ink-700 shadow-sm">
              <p id="modalReviewText"></p>
            </div>
          </div>
          <div class="mt-6 space-y-4">
            <div>
              <h4 class="text-sm font-semibold uppercase tracking-[0.24em] text-sage-400">Visitor reviews</h4>
              <div id="modalReviewList" class="mt-4 space-y-4">
                <div class="rounded-3xl bg-cream-50 p-4 text-sm text-ink-700">
                  <p class="font-semibold text-forest-900">"A gorgeous landscape and peaceful trail."</p>
                  <p class="mt-2 text-ink-600">— Local traveler</p>
                </div>
                <div class="rounded-3xl bg-cream-50 p-4 text-sm text-ink-700">
                  <p class="font-semibold text-forest-900">"Great spot for a family picnic."</p>
                  <p class="mt-2 text-ink-600">— Weekend explorer</p>
                </div>
              </div>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3">
              <button id="modalBookBtn" type="button" class="inline-flex items-center justify-center gap-2 rounded-3xl bg-forest-900 px-6 py-3 text-sm font-semibold text-cream-50 transition hover:bg-forest-800">Add to travel list</button>
              <button id="modalSaveBtn" type="button" aria-pressed="false" class="inline-flex items-center gap-2 rounded-3xl border border-cream-200 bg-cream-50 px-5 py-3 text-sm font-semibold text-forest-900 transition hover:bg-cream-100">Save</button>
            </div>
          </div>
        </div>
      </div>
      <button id="closeReviewModal" type="button" aria-label="Close review" class="absolute right-5 top-5 inline-flex h-11 w-11 items-center justify-center rounded-full bg-cream-50 text-forest-900 shadow-sm ring-1 ring-cream-200 hover:bg-cream-100">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
      </button>
    </div>
  </div>

 
@endsection

@push('scripts')
<script>
  const destinations = [
    {
      title: 'Kabatanga Falls',
      category: 'Nature',
      description: 'A lush waterfall with trails, swimming pools, and quiet picnic areas just outside Balingasag.',
      image: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=80',
      location: 'Balingasag, Philippines',
      rating: '4.9',
      subtitle: 'Waterfall Escape',
      summary: 'Refreshing trails, pools, and forest walks.',
      reviewText: 'Incredible views and a beautiful hike. We loved the water, the picnic areas, and the calm atmosphere.',
    },
    {
      title: 'San Roque Parish Church',
      category: 'Heritage',
      description: 'Historic church known for its beautiful architecture and local festivals.',
      image: 'https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1400&q=80',
      location: 'Balingasag, Philippines',
      rating: '4.8',
      subtitle: 'Heritage Landmark',
      summary: 'Historic architecture with local festivals and art.',
      reviewText: 'Absolutely charming. The church grounds felt calm and welcoming, with lovely local art.',
    },
    {
      title: 'Macajalar Bay Boardwalk',
      category: 'Scenic',
      description: 'A sunset-friendly seaside boardwalk with local food and ocean views.',
      image: 'https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1400&q=80',
      location: 'Balingasag, Philippines',
      rating: '4.7',
      subtitle: 'Seaside Stroll',
      summary: 'Sunset views, local snacks, and ocean breeze.',
      reviewText: 'Perfect sunset spot. The boardwalk had lovely snacks and made for a relaxing evening.',
    },
    {
      title: 'Cameo Island',
      category: 'Beach',
      description: 'Crystal blue water and easy beach-side adventure for a day of sun and scenery.',
      image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1400&q=80',
      location: 'Balingasag, Philippines',
      rating: '4.6',
      subtitle: 'Island Getaway',
      summary: 'Crystal waters and easy beach-side adventure.',
      reviewText: 'A perfect island escape with calm water and beautiful views.',
    },
  ];

  const heroPreviewImage = document.getElementById('heroPreviewImage');
  const heroPreviewTitle = document.getElementById('heroPreviewTitle');
  const heroPreviewDescription = document.getElementById('heroPreviewDescription');
  const heroPreviewCategory = document.getElementById('heroPreviewCategory');
  const heroPreviewBook = document.getElementById('heroPreviewBook');
  const heroPreviewSave = document.getElementById('heroPreviewSave');
  const heroPreviewReview = document.getElementById('heroPreviewReview');

  const placeCards = Array.from(document.querySelectorAll('.place-card'));
  const reviewModal = document.getElementById('reviewModal');
  const modalImage = document.getElementById('modalImage');
  const modalTitle = document.getElementById('modalTitle');
  const modalCategory = document.getElementById('modalCategory');
  const modalMeta = document.getElementById('modalMeta');
  const modalReviewText = document.getElementById('modalReviewText');
  const modalBookBtn = document.getElementById('modalBookBtn');
  const modalSaveBtn = document.getElementById('modalSaveBtn');
  const closeReviewModal = document.getElementById('closeReviewModal');

  let activeIndex = 0;
  const savedStates = {};
  const bookedStates = {};

  function updateHeroPreview(index) {
    const destination = destinations[index];
    if (!destination) return;

    heroPreviewImage.src = destination.image;
    heroPreviewImage.alt = destination.title;
    heroPreviewTitle.textContent = destination.title;
    heroPreviewDescription.textContent = destination.description;
    heroPreviewCategory.textContent = destination.category;
    heroPreviewBook.textContent = bookedStates[index] ? 'Added' : 'Add to travel list';
    heroPreviewSave.textContent = savedStates[index] ? 'Saved' : 'Save';
    heroPreviewSave.setAttribute('aria-pressed', savedStates[index] || false);
    heroPreviewSave.classList.toggle('bg-cream-50', savedStates[index]);
    heroPreviewSave.classList.toggle('text-forest-900', savedStates[index]);
    activeIndex = index;
    placeCards.forEach((card, cardIndex) => {
      card.classList.toggle('border-forest-900', cardIndex === index);
      card.classList.toggle('shadow-xl', cardIndex === index);
    });
  }

  function openReview(index) {
    const destination = destinations[index];
    if (!destination) return;

    modalImage.src = destination.image;
    modalImage.alt = destination.title;
    modalTitle.textContent = destination.title;
    modalCategory.textContent = `${destination.category} review`;
    modalMeta.textContent = `Rating ${destination.rating} • ${index + 1} of ${destinations.length}`;
    modalReviewText.textContent = destination.reviewText;
    modalBookBtn.textContent = bookedStates[index] ? 'Added' : 'Add to travel list';
    modalSaveBtn.textContent = savedStates[index] ? 'Saved' : 'Save';
    modalSaveBtn.setAttribute('aria-pressed', savedStates[index] || false);
    reviewModal.classList.remove('hidden');
  }

  function closeReview() {
    reviewModal.classList.add('hidden');
  }

  function toggleSave() {
    savedStates[activeIndex] = !savedStates[activeIndex];
    updateHeroPreview(activeIndex);
  }

  function toggleBook() {
    bookedStates[activeIndex] = !bookedStates[activeIndex];
    updateHeroPreview(activeIndex);
  }

  placeCards.forEach((card) => {
    card.addEventListener('click', () => {
      const index = Number(card.dataset.index);
      updateHeroPreview(index);
    });
  });

  heroPreviewReview.addEventListener('click', () => openReview(activeIndex));
  heroPreviewSave.addEventListener('click', toggleSave);
  heroPreviewBook.addEventListener('click', toggleBook);
  modalSaveBtn.addEventListener('click', toggleSave);
  modalBookBtn.addEventListener('click', toggleBook);
  closeReviewModal.addEventListener('click', closeReview);

  reviewModal.addEventListener('click', (event) => {
    if (event.target === reviewModal) {
      closeReview();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !reviewModal.classList.contains('hidden')) {
      closeReview();
    }
  });

  updateHeroPreview(0);
</script>
@endpush