@extends('admin.layout')

@section('title', 'Security Logs')
@section('page-subtitle', 'Security monitoring')
@section('security-logs-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Security</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Security Logs</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Review authentication events and security-related activity across the admin panel.</p>
  </section>

  <section class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-cream-200 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-sm">
      <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
      <input id="searchInput" type="text" placeholder="Search events…"
        class="w-full rounded-2xl border border-cream-200 bg-cream-50 py-2.5 pl-10 pr-4 text-sm text-ink-900 placeholder:text-ink-400 focus:border-forest-700 focus:bg-white">
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <select id="eventFilter" class="rounded-2xl border border-cream-200 bg-cream-50 px-3.5 py-2.5 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
        <option value="">All event types</option>
        <option value="login">Login</option>
        <option value="password_change">Password change</option>
        <option value="permission">Role change</option>
      </select>
      <button id="clearEventsBtn" type="button" class="rounded-2xl bg-forest-900 px-4 py-2 text-sm font-semibold text-cream-50 hover:bg-forest-700">Clear reviewed</button>
    </div>
  </section>

  <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
    <div class="grid grid-cols-6 gap-4 border-b border-cream-200 bg-cream-50 px-5 py-4 text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">
      <span>Date</span>
      <span>Event</span>
      <span class="col-span-2">Details</span>
      <span>Status</span>
      <span class="text-right">Actions</span>
    </div>
    <div id="eventTable" class="divide-y divide-cream-200"></div>
  </div>

  <div id="emptyState" class="hidden rounded-3xl border border-dashed border-cream-200 bg-white py-16 text-center">
    <p class="font-serif text-xl font-medium text-forest-900">No security events found</p>
    <p class="mt-2 text-sm text-ink-600">Use the search or event filter to locate security entries.</p>
  </div>
@endsection

@push('scripts')
<script>
(function () {
  let events = [
    { id: crypto.randomUUID(), date: '2026-08-04 09:12', type: 'login', details: 'Admin user Maria Santos signed in from 192.168.0.22.', status: 'New' },
    { id: crypto.randomUUID(), date: '2026-08-03 17:45', type: 'password_change', details: 'Password changed for user josep@example.com.', status: 'Reviewed' },
    { id: crypto.randomUUID(), date: '2026-08-02 08:30', type: 'permission', details: 'Role updated to Administrator for user ana@example.com.', status: 'New' },
  ];

  const eventTable = document.getElementById('eventTable');
  const searchInput = document.getElementById('searchInput');
  const eventFilter = document.getElementById('eventFilter');
  const clearEventsBtn = document.getElementById('clearEventsBtn');
  const emptyState = document.getElementById('emptyState');

  function render() {
    const query = searchInput.value.trim().toLowerCase();
    const type = eventFilter.value;
    const filtered = events.filter(entry => {
      const matchesQuery = !query || entry.details.toLowerCase().includes(query) || entry.date.includes(query);
      const matchesType = !type || entry.type === type;
      return matchesQuery && matchesType;
    });

    eventTable.innerHTML = '';
    emptyState.classList.toggle('hidden', filtered.length !== 0);

    filtered.forEach(entry => {
      const row = document.createElement('div');
      row.className = 'grid grid-cols-6 gap-4 px-5 py-4 text-sm text-ink-700 sm:grid-cols-6';
      row.innerHTML = `
        <span>${entry.date}</span>
        <span class="capitalize font-semibold text-forest-900">${entry.type.replace('_', ' ')}</span>
        <span class="col-span-2 text-ink-600">${entry.details}</span>
        <span class="font-semibold ${entry.status === 'New' ? 'text-amber-700' : 'text-sage-700'}">${entry.status}</span>
        <div class="flex items-center justify-end gap-2">
          <button data-mark-reviewed="${entry.id}" class="rounded-2xl border border-cream-200 bg-cream-50 px-3 py-2 text-sm font-semibold text-forest-900 hover:bg-cream-100">Mark reviewed</button>
          <button data-delete="${entry.id}" class="rounded-2xl border border-red-200 bg-red-100 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-200">Delete</button>
        </div>`;
      eventTable.appendChild(row);
    });
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

  document.addEventListener('click', (event) => {
    const markButton = event.target.closest('[data-mark-reviewed]');
    const deleteButton = event.target.closest('[data-delete]');
    if (markButton) {
      const id = markButton.dataset.markReviewed;
      const entry = events.find(e => e.id === id);
      if (entry) {
        entry.status = 'Reviewed';
        render();
        showToast('Marked reviewed');
      }
    }
    if (deleteButton) {
      events = events.filter(e => e.id !== deleteButton.dataset.delete);
      render();
      showToast('Security event removed');
    }
  });

  searchInput.addEventListener('input', render);
  eventFilter.addEventListener('change', render);
  clearEventsBtn.addEventListener('click', () => {
    events = events.filter(e => e.status !== 'Reviewed');
    render();
    showToast('Reviewed events cleared');
  });

  render();
})();
</script>
@endpush
