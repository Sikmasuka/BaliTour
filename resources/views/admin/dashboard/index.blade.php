@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page-subtitle', 'Overview & Operations')
@section('dashboard-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <!-- Hero / welcome -->
  <section class="mb-8 overflow-hidden rounded-3xl bg-forest-900 p-8 shadow-sm sm:p-10 text-cream-50">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Overview</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">
      Good morning, Admin.
    </h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">
      Here's what's happening across the site today — destinations, reviews, system logs, and content that needs attention.
    </p>
  </section>

  <!-- Stat cards -->
  <section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <div class="flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Users</p>
        <span class="rounded-full bg-sage-300/40 px-2 py-1 text-[11px] font-semibold text-forest-800">+4.2%</span>
      </div>
      <p class="mt-4 font-serif text-4xl font-medium text-forest-900">3,910</p>
      <p class="mt-2 text-sm text-ink-600">Active accounts registered with the site.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <div class="flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Bookings</p>
        <span class="rounded-full bg-sage-300/40 px-2 py-1 text-[11px] font-semibold text-forest-800">+11%</span>
      </div>
      <p class="mt-4 font-serif text-4xl font-medium text-forest-900">1,284</p>
      <p class="mt-2 text-sm text-ink-600">Approved reservations this month.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <div class="flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Pending review</p>
        <span class="rounded-full bg-amber-100 px-2 py-1 text-[11px] font-semibold text-amber-700">Needs action</span>
      </div>
      <p class="mt-4 font-serif text-4xl font-medium text-forest-900">15</p>
      <p class="mt-2 text-sm text-ink-600">Items waiting for approval.</p>
    </article>
  </section>

  <!-- Quick actions + activity -->
  <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
      <div class="flex items-center justify-between gap-4">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Quick actions</p>
          <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">Manage core content</h2>
        </div>
        <span class="hidden rounded-full bg-cream-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-ink-600 sm:inline-flex">Admin</span>
      </div>

      <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="/admin/destinations" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
          <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
          </div>
          <p class="mt-3 text-base font-semibold text-forest-900">Destinations</p>
          <p class="mt-1 text-sm text-ink-600">Edit the places shown on the public site.</p>
        </a>
        <a href="/admin/events" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
          <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
          </div>
          <p class="mt-3 text-base font-semibold text-forest-900">Events</p>
          <p class="mt-1 text-sm text-ink-600">Publish upcoming festivals and tours.</p>
        </a>
        <a href="/admin/users" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
          <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.2"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/></svg>
          </div>
          <p class="mt-3 text-base font-semibold text-forest-900">Users</p>
          <p class="mt-1 text-sm text-ink-600">Review account roles and activity.</p>
        </a>
        <a href="/admin/bookings" class="rounded-2xl border border-cream-200 bg-cream-50 p-5 transition hover:-translate-y-0.5 hover:border-forest-800/20 hover:shadow-sm">
          <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-forest-900 text-cream-50">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M9 3v3M15 3v3M8.5 12.5l2.2 2.2L15.5 10"/></svg>
          </div>
          <p class="mt-3 text-base font-semibold text-forest-900">Bookings</p>
          <p class="mt-1 text-sm text-ink-600">Manage reservation status and requests.</p>
        </a>
      </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Recent activity</p>
      <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">What needs attention</h2>
      <ul class="mt-6 space-y-3">
        <li class="flex items-start gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
          <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-amber-500"></span>
          <p class="text-sm text-ink-600"><span class="font-semibold text-forest-900">5 new bookings</span> are pending approval.</p>
        </li>
        <li class="flex items-start gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
          <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-sage-400"></span>
          <p class="text-sm text-ink-600"><span class="font-semibold text-forest-900">4 destination listings</span> need updated photos.</p>
        </li>
        <li class="flex items-start gap-3 rounded-2xl border border-cream-200 bg-cream-50 p-4">
          <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-forest-800"></span>
          <p class="text-sm text-ink-600"><span class="font-semibold text-forest-900">2 unread messages</span> in the contact inbox.</p>
        </li>
      </ul>
      <a href="/admin/messages" class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-forest-900 hover:text-forest-700">
        Go to inbox
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
    </div>
  </section>

  <!-- Recent signups -->
  <section class="mt-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">User snapshot</p>
        <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">Recent signups</h2>
      </div>
      <a href="/admin/users" class="inline-flex items-center gap-1.5 text-sm font-semibold text-forest-900 hover:text-forest-700">
        View all users
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
    </div>

    <div class="mt-6 overflow-x-auto">
      <table class="min-w-full divide-y divide-cream-200 text-left text-sm">
        <thead class="bg-cream-50 text-ink-600">
          <tr>
            <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">User</th>
            <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">Email</th>
            <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">Role</th>
            <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em]">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-cream-200">
          <tr>
            <td class="whitespace-nowrap px-4 py-4 font-medium text-forest-900">Maria Santos</td>
            <td class="whitespace-nowrap px-4 py-4 text-ink-600">maria.santos@balingasag.gov.ph</td>
            <td class="whitespace-nowrap px-4 py-4"><span class="rounded-full bg-forest-900/10 px-2.5 py-1 text-xs font-semibold text-forest-900">Admin</span></td>
            <td class="whitespace-nowrap px-4 py-4"><span class="inline-flex items-center gap-1.5 text-ink-600"><span class="h-1.5 w-1.5 rounded-full bg-sage-400"></span>Active</span></td>
          </tr>
          <tr>
            <td class="whitespace-nowrap px-4 py-4 font-medium text-forest-900">Jomar Villanueva</td>
            <td class="whitespace-nowrap px-4 py-4 text-ink-600">jomar.v@gmail.com</td>
            <td class="whitespace-nowrap px-4 py-4"><span class="rounded-full bg-cream-200 px-2.5 py-1 text-xs font-semibold text-ink-600">Staff</span></td>
            <td class="whitespace-nowrap px-4 py-4"><span class="inline-flex items-center gap-1.5 text-ink-600"><span class="h-1.5 w-1.5 rounded-full bg-sage-400"></span>Active</span></td>
          </tr>
          <tr>
            <td class="whitespace-nowrap px-4 py-4 font-medium text-forest-900">Ana Reyes</td>
            <td class="whitespace-nowrap px-4 py-4 text-ink-600">ana.reyes@gmail.com</td>
            <td class="whitespace-nowrap px-4 py-4"><span class="rounded-full bg-cream-200 px-2.5 py-1 text-xs font-semibold text-ink-600">Visitor</span></td>
            <td class="whitespace-nowrap px-4 py-4"><span class="inline-flex items-center gap-1.5 text-ink-600"><span class="h-1.5 w-1.5 rounded-full bg-sage-400"></span>Active</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
@endsection
