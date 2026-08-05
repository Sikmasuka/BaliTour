@extends('admin.layout')

@section('title', 'Manage Bookings')
@section('page-subtitle', 'Booking management')
@section('bookings-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Operations</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Manage Bookings</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Track reservations, confirmations, and booking workflows across the site.</p>
  </section>
  <section class="grid gap-4 sm:grid-cols-2">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Active bookings</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Ongoing reservations</h2>
      <p class="mt-3 text-sm text-ink-600">Review current trips and ensure reservations are confirmed and up to date.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Booking requests</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Approve or update requests</h2>
      <p class="mt-3 text-sm text-ink-600">Process new booking submissions and manage customer requests in one place.</p>
    </article>
  </section>
@endsection
