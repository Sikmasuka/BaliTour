@extends('tourist.layout')

@section('title', 'Travel List')
@section('page-subtitle', 'Travel List')
@section('booking-history-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">History</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Travel List</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Review your completed and upcoming travel list items in one place.</p>
  </section>

  <section class="space-y-4">
    <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <div class="relative h-52 overflow-hidden bg-slate-100">
        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1543167249-ebb1b0a5dded?auto=format&fit=crop&w=1200&q=80" alt="Nyepi Festival celebration">
      </div>
      <div class="p-6">
        <div class="flex items-center justify-between gap-4">
          <div>
            <h2 class="font-serif text-xl font-medium text-forest-900">Nyepi Festival</h2>
            <p class="mt-2 text-sm text-ink-600">March 11, 2027 · Confirmed</p>
          </div>
          <span class="rounded-full bg-sage-100 px-3 py-1 text-xs font-semibold uppercase text-forest-900">Completed</span>
        </div>
        <p class="mt-4 text-sm text-ink-600">A cultural festival experience with local guides and a comfortable stay.</p>
      </div>
    </article>
    <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200" data-index="0">
      <div class="relative h-52 overflow-hidden bg-slate-100">
        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1514516870925-4f2dcf632f46?auto=format&fit=crop&w=1200&q=80" alt="Mango Festival celebration">
      </div>
      <div class="p-6">
        <div class="flex items-center justify-between gap-4">
          <div>
            <h2 class="font-serif text-xl font-medium text-forest-900">Mango Festival</h2>
            <p class="mt-2 text-sm text-ink-600">July 22, 2027 · Upcoming</p>
          </div>
          <span class="rounded-full bg-cream-100 px-3 py-1 text-xs font-semibold uppercase text-ink-600">Upcoming</span>
        </div>
        <p class="mt-4 text-sm text-ink-600">A planned visit to local markets and heritage sites with guided tours.</p>
        <div class="mt-6 flex flex-wrap gap-3">
          <button type="button" data-index="0" class="cancel-booking inline-flex items-center justify-center rounded-full border border-ink-200 bg-cream-100 px-5 py-3 text-sm font-semibold text-ink-700 transition hover:bg-cream-200">Remove from travel list</button>
        </div>
      </div>
    </article>
  </section>

@push('scripts')
<script>
  document.querySelectorAll('.cancel-booking').forEach((button) => {
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
