@extends('admin.layout')

@section('title', 'System Logs')
@section('page-subtitle', 'System diagnostics')
@section('system-logs-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">System</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">System Logs</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Inspect platform activity, errors, and system events for diagnostics.</p>
  </section>

  <section class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-cream-200 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative w-full sm:max-w-sm">
      <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
      <input id="searchInput" type="text" placeholder="Search logs…"
        class="w-full rounded-2xl border border-cream-200 bg-cream-50 py-2.5 pl-10 pr-4 text-sm text-ink-900 placeholder:text-ink-400 focus:border-forest-700 focus:bg-white">
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <select id="levelFilter" class="rounded-2xl border border-cream-200 bg-cream-50 px-3.5 py-2.5 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
        <option value="">All levels</option>
        <option value="error">Error</option>
        <option value="warning">Warning</option>
        <option value="info">Info</option>
      </select>
      <button id="clearLogsBtn" type="button" class="rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Clear logs</button>
    </div>
  </section>

  <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
    <div class="grid grid-cols-6 gap-4 border-b border-cream-200 bg-cream-50 px-5 py-4 text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">
      <span>Timestamp</span>
      <span>Level</span>
      <span class="col-span-2">Message</span>
      <span>Source</span>
      <span class="text-right">Actions</span>
    </div>
    <div id="logTable" class="divide-y divide-cream-200"></div>
  </div>

  <div id="emptyState" class="hidden rounded-3xl border border-dashed border-cream-200 bg-white py-16 text-center">
    <p class="font-serif text-xl font-medium text-forest-900">No logs found</p>
    <p class="mt-2 text-sm text-ink-600">Use the search or level filter to locate events, or reload the page to refresh the view.</p>
  </div>
@endsection

@push('scripts')
<script>
(function () {
  let logs = [
    { id: crypto.randomUUID(), timestamp: '2026-08-01 14:23:09', level: 'error', message: 'Database connection timed out during report generation.', source: 'Backend' },
    { id: crypto.randomUUID(), timestamp: '2026-08-02 08:15:44', level: 'warning', message: 'Payment gateway returned a 502 response for booking #428.', source: 'Payments' },
    { id: crypto.randomUUID(), timestamp: '2026-08-03 12:04:17', level: 'info', message: 'Daily log rotation completed successfully.', source: 'System' },
  ];

  const logTable = document.getElementById('logTable');
  const searchInput = document.getElementById('searchInput');
  const levelFilter = document.getElementById('levelFilter');
  const clearLogsBtn = document.getElementById('clearLogsBtn');
  const emptyState = document.getElementById('emptyState');
  const confirmOverlay = document.createElement('div');
  let pendingClear = false;

  function render() {
    const query = searchInput.value.trim().toLowerCase();
    const level = levelFilter.value;
    const filtered = logs.filter(log => {
      const matchesQuery = !query || log.message.toLowerCase().includes(query) || log.source.toLowerCase().includes(query) || log.timestamp.includes(query);
      const matchesLevel = !level || log.level === level;
      return matchesQuery && matchesLevel;
    });

    logTable.innerHTML = '';
    emptyState.classList.toggle('hidden', filtered.length !== 0);

    filtered.forEach(log => {
      const row = document.createElement('div');
      row.className = 'grid grid-cols-6 gap-4 px-5 py-4 text-sm text-ink-700 sm:grid-cols-6';
      row.innerHTML = `
        <span>${log.timestamp}</span>
        <span class="capitalize font-semibold ${log.level === 'error' ? 'text-red-700' : log.level === 'warning' ? 'text-amber-700' : 'text-forest-900'}">${log.level}</span>
        <span class="col-span-2 text-ink-600">${log.message}</span>
        <span>${log.source}</span>
        <div class="flex items-center justify-end gap-2">
          <button data-delete="${log.id}" class="rounded-2xl border border-cream-200 bg-cream-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button>
        </div>`;
      logTable.appendChild(row);
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

  function deleteLog(id) {
    logs = logs.filter(log => log.id !== id);
    render();
    showToast('Log entry removed');
  }

  function confirmClear() {
    confirmOverlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-forest-900/50 p-4';
    confirmOverlay.innerHTML = `
      <div class="w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-red-50 text-red-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
        </div>
        <h3 class="mt-4 font-serif text-xl font-medium text-forest-900">Clear system logs?</h3>
        <p class="mt-1.5 text-sm text-ink-600">This removes all visible system log entries from the admin interface.</p>
        <div class="mt-6 flex justify-end gap-3">
          <button id="cancelClear" class="rounded-2xl border border-cream-200 bg-white px-4 py-2.5 text-sm font-semibold text-ink-900 hover:bg-cream-100">Cancel</button>
          <button id="confirmClear" class="rounded-2xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Clear</button>
        </div>
      </div>`;
    document.body.appendChild(confirmOverlay);
    document.getElementById('cancelClear').addEventListener('click', () => confirmOverlay.remove());
    document.getElementById('confirmClear').addEventListener('click', () => {
      logs = [];
      render();
      showToast('System logs cleared');
      confirmOverlay.remove();
    });
  }

  document.addEventListener('click', (event) => {
    const deleteBtn = event.target.closest('[data-delete]');
    if (deleteBtn) deleteLog(deleteBtn.dataset.delete);
  });

  searchInput.addEventListener('input', render);
  levelFilter.addEventListener('change', render);
  clearLogsBtn.addEventListener('click', confirmClear);

  render();
})();
</script>
@endpush
