@extends('user.layout')

@section('title', 'Notifications')
@section('page-subtitle', 'Notifications')
@section('notifications-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Alerts</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Notifications</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">See updates about your trips, bookmarks, reviews, and travel offers.</p>
  </section>

  <section class="space-y-4">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-sm font-semibold text-forest-900">Travel list updated</p>
      <p class="mt-2 text-sm text-ink-600">Your travel list item for the Davao island tour is ready.</p>
      <p class="mt-4 text-xs uppercase tracking-[0.22em] text-sage-500">2 hours ago</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-sm font-semibold text-forest-900">Review published</p>
      <p class="mt-2 text-sm text-ink-600">Your recent review for Kabatanga Falls is now visible to travelers.</p>
      <p class="mt-4 text-xs uppercase tracking-[0.22em] text-sage-500">Yesterday</p>
    </article>
  </section>
@endsection