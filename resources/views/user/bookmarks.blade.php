@extends('user.layout')

@section('title', 'Bookmarks')
@section('page-subtitle', 'Bookmarks')
@section('bookmarks-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Saved</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Bookmarks</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Review places and events you have saved for later planning.</p>
  </section>

  <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <article class="relative overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <button type="button" data-index="0" class="bookmark-toggle absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-forest-900 shadow-sm transition hover:bg-cream-100" aria-label="Remove Kabatanga Falls from bookmarks">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 20.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 10.54L12 20.35z"/></svg>
      </button>
      <div class="h-48 overflow-hidden bg-slate-100">
        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80" alt="Kabatanga Falls">
      </div>
      <div class="p-6">
        <h2 class="font-serif text-xl font-medium text-forest-900">Kabatanga Falls</h2>
        <p class="mt-3 text-sm text-ink-600">Nature retreat with a swimming area and picnic spots.</p>
      </div>
    </article>

    <article class="relative overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <button type="button" data-index="1" class="bookmark-toggle absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-forest-900 shadow-sm transition hover:bg-cream-100" aria-label="Remove San Roque Parish Church from bookmarks">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 20.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 10.54L12 20.35z"/></svg>
      </button>
      <div class="h-48 overflow-hidden bg-slate-100">
        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1200&q=80" alt="San Roque Parish Church">
      </div>
      <div class="p-6">
        <h2 class="font-serif text-xl font-medium text-forest-900">San Roque Parish Church</h2>
        <p class="mt-3 text-sm text-ink-600">Historic heritage site with local culture and architecture.</p>
      </div>
    </article>

    <article class="relative overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <button type="button" data-index="2" class="bookmark-toggle absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-forest-900 shadow-sm transition hover:bg-cream-100" aria-label="Remove Macajalar Bay Boardwalk from bookmarks">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 20.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 10.54L12 20.35z"/></svg>
      </button>
      <div class="h-48 overflow-hidden bg-slate-100">
        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1200&q=80" alt="Macajalar Bay Boardwalk">
      </div>
      <div class="p-6">
        <h2 class="font-serif text-xl font-medium text-forest-900">Macajalar Bay Boardwalk</h2>
        <p class="mt-3 text-sm text-ink-600">Coastal promenade perfect for sunset walks.</p>
      </div>
    </article>
  </section>

@push('scripts')
<script>
  document.querySelectorAll('.bookmark-toggle').forEach((button) => {
    button.addEventListener('click', () => {
      const card = button.closest('article');
      if (!card) return;
      card.classList.add('transition', 'duration-300', 'opacity-0', 'scale-95');
      setTimeout(() => card.remove(), 250);
    });
  });
</script>
@endpush
@endsection