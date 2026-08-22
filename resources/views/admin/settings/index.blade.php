@extends('admin.layout')

@section('title', 'Settings')
@section('page-subtitle', 'Application configuration')
@section('settings-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">System</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Settings</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Configure site options, admin controls, and global preferences.</p>
  </section>

  <form id="settingsForm" class="grid gap-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:grid-cols-2">
    <div>
      <label for="siteTitle" class="mb-1.5 block text-sm font-medium text-ink-900">Site title</label>
      <input id="siteTitle" type="text" class="w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white" placeholder="Balingasag Tourism" />
    </div>
    <div>
      <label for="contactEmail" class="mb-1.5 block text-sm font-medium text-ink-900">Contact email</label>
      <input id="contactEmail" type="email" class="w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white" placeholder="hello@balitours.local" />
    </div>
    <div class="sm:col-span-2">
      <label for="homepageText" class="mb-1.5 block text-sm font-medium text-ink-900">Homepage hero text</label>
      <textarea id="homepageText" rows="3" class="w-full resize-none rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white" placeholder="A warm welcome message for visitors"></textarea>
    </div>
    <div>
      <label class="mb-1.5 block text-sm font-medium text-ink-900">Maintenance mode</label>
      <div class="flex items-center gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
        <span class="text-sm text-ink-700">Inactive</span>
        <button type="button" id="maintenanceToggle" data-on="false" class="relative h-6 w-11 rounded-full bg-slate-200 transition">
          <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
        </button>
        <span class="text-sm text-forest-900">Active</span>
      </div>
      <input type="hidden" id="maintenanceMode" value="false" />
    </div>
    <div>
      <label for="timezone" class="mb-1.5 block text-sm font-medium text-ink-900">Default timezone</label>
      <select id="timezone" class="w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white">
        <option value="Asia/Manila">Asia/Manila</option>
        <option value="UTC">UTC</option>
        <option value="Asia/Jakarta">Asia/Jakarta</option>
      </select>
    </div>
    <div class="sm:col-span-2 flex flex-col gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-5">
      <div>
        <p class="text-sm font-semibold text-forest-900">Admin notifications</p>
        <p class="mt-1 text-sm text-ink-600">Choose whether admins receive message and booking alerts by email.</p>
      </div>
      <label class="inline-flex items-center gap-3 text-sm">
        <input id="emailAlerts" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-forest-900 focus:ring-forest-900" />
        Enable email alerts
      </label>
    </div>
    <div class="sm:col-span-2 flex flex-wrap items-center justify-between gap-3">
      <button id="resetBtn" type="button" class="rounded-2xl border border-cream-200 bg-white px-5 py-3 text-sm font-semibold text-ink-900 hover:bg-cream-100">Reset defaults</button>
      <button type="submit" class="rounded-2xl bg-forest-900 px-5 py-3 text-sm font-semibold text-cream-50 shadow-sm hover:bg-forest-700">Save changes</button>
    </div>
  </form>

  <div id="toast" class="pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2 rounded-2xl bg-forest-900 px-5 py-3 text-sm font-medium text-cream-50 opacity-0 shadow-lg transition-all duration-300"></div>
@endsection

@push('scripts')
<script>
(function () {
  const defaults = {
    siteTitle: 'Balingasag Tourism',
    contactEmail: 'hello@balitours.local',
    homepageText: 'Welcome to Balingasag, your gateway to authentic coastal culture and nature experiences.',
    maintenanceMode: 'false',
    timezone: 'Asia/Manila',
    emailAlerts: true,
  };

  const storageKey = 'admin-settings';
  const form = document.getElementById('settingsForm');
  const siteTitle = document.getElementById('siteTitle');
  const contactEmail = document.getElementById('contactEmail');
  const homepageText = document.getElementById('homepageText');
  const maintenanceMode = document.getElementById('maintenanceMode');
  const maintenanceToggle = document.getElementById('maintenanceToggle');
  const timezone = document.getElementById('timezone');
  const emailAlerts = document.getElementById('emailAlerts');
  const resetBtn = document.getElementById('resetBtn');
  const toast = document.getElementById('toast');

  function showToast(message) {
    toast.textContent = message;
    toast.classList.remove('opacity-0', 'translate-y-4');
    setTimeout(() => toast.classList.add('opacity-0', 'translate-y-4'), 2000);
  }

  function setToggle(on) {
    maintenanceMode.value = on ? 'true' : 'false';
    maintenanceToggle.dataset.on = on;
    maintenanceToggle.classList.toggle('bg-forest-900', on);
    maintenanceToggle.classList.toggle('bg-slate-200', !on);
    maintenanceToggle.querySelector('span').classList.toggle('translate-x-5', on);
  }

  function loadSettings() {
    const saved = localStorage.getItem(storageKey);
    const config = saved ? JSON.parse(saved) : defaults;
    siteTitle.value = config.siteTitle;
    contactEmail.value = config.contactEmail;
    homepageText.value = config.homepageText;
    timezone.value = config.timezone;
    emailAlerts.checked = config.emailAlerts;
    setToggle(config.maintenanceMode === 'true');
  }

  function saveSettings() {
    const next = {
      siteTitle: siteTitle.value.trim() || defaults.siteTitle,
      contactEmail: contactEmail.value.trim() || defaults.contactEmail,
      homepageText: homepageText.value.trim() || defaults.homepageText,
      maintenanceMode: maintenanceMode.value,
      timezone: timezone.value,
      emailAlerts: emailAlerts.checked,
    };
    localStorage.setItem(storageKey, JSON.stringify(next));
    showToast('Settings saved');
  }

  maintenanceToggle.addEventListener('click', () => setToggle(maintenanceToggle.dataset.on !== 'true'));
  form.addEventListener('submit', (e) => { e.preventDefault(); saveSettings(); });
  resetBtn.addEventListener('click', () => {
    localStorage.removeItem(storageKey);
    loadSettings();
    showToast('Defaults restored');
  });

  loadSettings();
})();
</script>
@endpush
