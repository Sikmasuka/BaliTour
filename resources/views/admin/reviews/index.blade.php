@extends('admin.layout')

@section('title', 'Manage Reviews')
@section('page-subtitle', 'Reviews management')
@section('reviews-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 flex flex-col gap-4 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:flex-row sm:items-center sm:justify-between sm:p-10">
    <div>
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Content</p>
      <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Manage Reviews</h1>
      <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Moderate traveler feedback and keep public reviews trustworthy.</p>
    </div>
  </section>

  <section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Total reviews</p>
      <p id="statTotal" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
    </article>
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Pending</p>
      <p id="statPending" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
    </article>
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Approved</p>
      <p id="statApproved" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
    </article>
    <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Rejected</p>
      <p id="statRejected" class="mt-2 font-serif text-3xl font-medium text-forest-900">0</p>
    </article>
  </section>

  <section class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-cream-200 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-sm">
      <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
      <input id="searchInput" type="text" placeholder="Search reviews…"
        class="w-full rounded-2xl border border-cream-200 bg-cream-50 py-2.5 pl-10 pr-4 text-sm text-ink-900 placeholder:text-ink-400 focus:border-forest-700 focus:bg-white">
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <select id="statusFilter" class="rounded-2xl border border-cream-200 bg-cream-50 px-3.5 py-2.5 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
        <option value="">All status</option>
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
      </select>
      <button id="clearFiltersBtn" type="button" class="rounded-2xl bg-forest-900 px-4 py-2 text-sm font-semibold text-cream-50 hover:bg-forest-700">Clear filters</button>
    </div>
  </section>

  <section id="grid" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3"></section>

  <div id="emptyState" class="hidden flex-col items-center justify-center rounded-3xl border border-dashed border-cream-200 bg-white py-16 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-cream-100 text-forest-900">
      <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2m-8 0v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7"/></svg>
    </div>
    <p class="mt-4 font-serif text-xl font-medium text-forest-900">No reviews match this filter</p>
    <p class="mt-1 text-sm text-ink-600">Add a new review or reset the filters to see more.</p>
  </div>
@endsection

@push('scripts')
<script>
(function () {
  const reviews = [
    { id: crypto.randomUUID(), author: 'Ana Rivera', destination: 'Kabatanga Falls', rating: 5, status: 'Pending', text: 'A breathtaking waterfall with a gentle trail. We loved the shaded path and swimming area.', date: '2026-06-12' },
    { id: crypto.randomUUID(), author: 'Mark Santos', destination: 'San Roque Parish Church', rating: 4, status: 'Approved', text: 'A peaceful heritage site with beautiful architecture and a warm local welcome.', date: '2026-05-28' },
    { id: crypto.randomUUID(), author: 'Leah Cruz', destination: 'Macajalar Bay Boardwalk', rating: 3, status: 'Rejected', text: 'The sunset was nice, but the walk was more crowded than expected.', date: '2026-07-04' },
  ];

  let items = [...reviews];
  const grid = document.getElementById('grid');
  const searchInput = document.getElementById('searchInput');
  const statusFilter = document.getElementById('statusFilter');
  const clearFiltersBtn = document.getElementById('clearFiltersBtn');
  const emptyState = document.getElementById('emptyState');

  function updateStats() {
    document.getElementById('statTotal').textContent = items.length;
    document.getElementById('statPending').textContent = items.filter(r => r.status === 'Pending').length;
    document.getElementById('statApproved').textContent = items.filter(r => r.status === 'Approved').length;
    document.getElementById('statRejected').textContent = items.filter(r => r.status === 'Rejected').length;
  }

  function showToast(message) {
    let toast = document.getElementById('toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'toast';
      toast.className = 'pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2 rounded-2xl bg-forest-900 px-5 py-3 text-sm font-medium text-cream-50 opacity-0 shadow-lg transition-all duration-300';
      document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.remove('opacity-0', 'translate-y-4');
    setTimeout(() => toast.classList.add('opacity-0', 'translate-y-4'), 2000);
  }

  function render() {
    const query = searchInput.value.trim().toLowerCase();
    const status = statusFilter.value;
    const filtered = items.filter(r => {
      const matchesSearch = !query || r.author.toLowerCase().includes(query) || r.destination.toLowerCase().includes(query) || r.text.toLowerCase().includes(query);
      const matchesStatus = !status || r.status === status;
      return matchesSearch && matchesStatus;
    });

    grid.innerHTML = '';
    emptyState.classList.toggle('hidden', filtered.length !== 0);
    emptyState.classList.toggle('flex', filtered.length === 0);

    filtered.forEach(review => {
      const card = document.createElement('article');
      card.className = 'group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200 transition hover:shadow-md';
      card.innerHTML = `
        <div class="p-5">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-ink-500">${review.destination}</p>
              <h3 class="mt-1 font-serif text-lg font-medium text-forest-900">${review.author}</h3>
            </div>
            <span class="rounded-full bg-cream-200 px-3 py-1 text-xs font-semibold text-ink-600">${review.rating} ★</span>
          </div>
          <p class="mt-4 text-sm leading-relaxed text-ink-600">${review.text}</p>
          <div class="mt-5 flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-ink-500">
            <span class="rounded-full bg-sage-200 px-3 py-1 text-forest-900">${review.status}</span>
            <span>${review.date}</span>
          </div>
          <div class="mt-5 flex flex-wrap gap-2">
            <button data-approve="${review.id}" class="rounded-2xl border border-sage-300 bg-sage-100 px-3 py-2 text-sm font-semibold text-forest-900 hover:bg-sage-200">Approve</button>
            <button data-reject="${review.id}" class="rounded-2xl border border-amber-200 bg-amber-100 px-3 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-200">Reject</button>
            <button data-delete="${review.id}" class="rounded-2xl border border-red-200 bg-red-100 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-200">Delete</button>
          </div>
        </div>`;
      grid.appendChild(card);
    });

    grid.querySelectorAll('[data-approve]').forEach(btn => btn.addEventListener('click', () => updateReviewStatus(btn.dataset.approve, 'Approved')));
    grid.querySelectorAll('[data-reject]').forEach(btn => btn.addEventListener('click', () => updateReviewStatus(btn.dataset.reject, 'Rejected')));
    grid.querySelectorAll('[data-delete]').forEach(btn => btn.addEventListener('click', () => deleteReview(btn.dataset.delete)));

    updateStats();
  }

  function updateReviewStatus(id, status) {
    const review = items.find(r => r.id === id);
    if (!review) return;
    review.status = status;
    render();
    showToast(`Review ${status.toLowerCase()}`);
  }

  function deleteReview(id) {
    if (!confirm('Delete this review?')) return;
    items = items.filter(r => r.id !== id);
    render();
    showToast('Review deleted');
  }

  searchInput.addEventListener('input', render);
  statusFilter.addEventListener('change', render);
  clearFiltersBtn.addEventListener('click', () => {
    searchInput.value = '';
    statusFilter.value = '';
    render();
  });

  render();
})();
</script>
@endpush
