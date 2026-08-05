@extends('user.layout')

@section('title', 'Dashboard')
@section('page-subtitle', 'Dashboard')
@section('dashboard-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Overview</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Welcome back, Maria</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Manage your trips, review requests, bookmarks, and notifications from one place.</p>
  </section>

  <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Travel List</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Your upcoming trips</h2>
      <p class="mt-3 text-sm text-ink-600">Check your travel list items, status updates, and itinerary changes.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Profile</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Edit your account</h2>
      <p class="mt-3 text-sm text-ink-600">Update contact details, preferences, and traveler information.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Notifications</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Latest alerts</h2>
      <p class="mt-3 text-sm text-ink-600">See the most recent travel list updates and travel recommendations.</p>
    </article>
  </section>

  {{-- Recent Visits Section --}}
  <section class="mt-8">
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
      <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Your trips</p>
          <h2 class="mt-2 font-serif text-2xl font-medium text-forest-900">Recent & Planned Visits</h2>
        </div>
        <a href="/user/booking-history" class="inline-flex items-center gap-1.5 text-sm font-semibold text-forest-900 hover:text-forest-700">
          View travel list
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
      <div class="mt-6 space-y-4">
        {{-- This is a placeholder. You should loop through user's visits from the controller. --}}
        <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-cream-200 bg-cream-50 p-4">
          <div>
            <p class="font-semibold text-forest-900">Nyepi Festival Experience</p>
            <p class="mt-1 text-sm text-ink-600">March 11, 2027 · Cultural tour</p>
          </div>
          <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold uppercase text-green-800">Completed</span>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-cream-200 bg-cream-50 p-4">
          <div>
            <p class="font-semibold text-forest-900">Kabatanga Falls Day Trip</p>
            <p class="mt-1 text-sm text-ink-600">September 15, 2026 · Nature hike</p>
          </div>
          <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold uppercase text-blue-800">Upcoming</span>
        </div>
      </div>
    </div>
  </section>

  <section class="mt-8 grid gap-4 xl:grid-cols-2">
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Quick links</p>
      <div class="mt-5 grid gap-3 sm:grid-cols-2">
        <a href="/user/edit-profile" class="rounded-2xl border border-cream-200 bg-cream-50 px-5 py-4 text-sm font-semibold text-forest-900 hover:bg-cream-100">Edit Profile</a>
        <a href="/user/bookmarks" class="rounded-2xl border border-cream-200 bg-cream-50 px-5 py-4 text-sm font-semibold text-forest-900 hover:bg-cream-100">Bookmarks</a>
        <a href="/user/booking-history" class="rounded-2xl border border-cream-200 bg-cream-50 px-5 py-4 text-sm font-semibold text-forest-900 hover:bg-cream-100">Travel List</a>
        <a href="/user/reviews" class="rounded-2xl border border-cream-200 bg-cream-50 px-5 py-4 text-sm font-semibold text-forest-900 hover:bg-cream-100">Leave Reviews</a>
      </div>
    </div>
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Tips</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Plan your next trip</h2>
      <p class="mt-3 text-sm text-ink-600">Save favorite locations, track bookings, and send reviews to help other travelers.</p>
    </div>
  </section>
@endsection