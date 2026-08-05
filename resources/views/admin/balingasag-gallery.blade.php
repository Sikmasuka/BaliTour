@extends('admin.layout')

@section('title', 'Balingasag Gallery')
@section('page-subtitle', 'Balingasag Places')
@section('balingasag-gallery-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Tourism</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Balingasag Gallery</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Browse featured Balingasag destinations with sample reviews and imagery designed for the public tourism site.</p>
  </section>

  <section class="grid gap-4 lg:grid-cols-3">
    <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <img class="h-64 w-full object-cover" src="https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1200&q=80" alt="Balingasag waterfall">
      <div class="p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-400">Nature</p>
        <h2 class="mt-3 font-serif text-2xl font-medium text-forest-900">Kabatanga Falls</h2>
        <p class="mt-3 text-sm leading-relaxed text-ink-600">A scenic waterfall retreat with nature trails, picnic spots, and cool river pools.</p>
        <div class="mt-5 flex items-center justify-between text-sm">
          <span class="rounded-full bg-sage-100 px-3 py-1 text-forest-900">4.9 ★</span>
          <span class="text-ink-500">312 reviews</span>
        </div>
      </div>
    </article>
    <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <img class="h-64 w-full object-cover" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80" alt="Heritage church interior">
      <div class="p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-400">Culture</p>
        <h2 class="mt-3 font-serif text-2xl font-medium text-forest-900">San Roque Parish Church</h2>
        <p class="mt-3 text-sm leading-relaxed text-ink-600">Historic church and community landmark known for its tranquil courtyard and local festivals.</p>
        <div class="mt-5 flex items-center justify-between text-sm">
          <span class="rounded-full bg-sage-100 px-3 py-1 text-forest-900">4.8 ★</span>
          <span class="text-ink-500">196 reviews</span>
        </div>
      </div>
    </article>
    <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-cream-200">
      <img class="h-64 w-full object-cover" src="https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1200&q=80" alt="Sunset boardwalk">
      <div class="p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-400">Scenic</p>
        <h2 class="mt-3 font-serif text-2xl font-medium text-forest-900">Macajalar Bay Boardwalk</h2>
        <p class="mt-3 text-sm leading-relaxed text-ink-600">A waterfront promenade ideal for sunset walks, local snacks, and seaside photography.</p>
        <div class="mt-5 flex items-center justify-between text-sm">
          <span class="rounded-full bg-sage-100 px-3 py-1 text-forest-900">4.7 ★</span>
          <span class="text-ink-500">145 reviews</span>
        </div>
      </div>
    </article>
  </section>

  <section class="mt-10 grid gap-6 lg:grid-cols-2">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <h2 class="font-serif text-2xl font-medium text-forest-900">Guest reviews</h2>
      <div class="mt-6 space-y-4">
        <div class="rounded-3xl bg-cream-50 p-5">
          <div class="flex items-center justify-between gap-3 text-sm text-ink-500">
            <span class="font-semibold text-forest-900">Kabatanga Falls</span>
            <span>5.0 ★</span>
          </div>
          <p class="mt-3 text-sm leading-relaxed text-ink-600">"The waterfall hike was stunning and the guide made everything easy. Absolutely recommend this for nature lovers."</p>
        </div>
        <div class="rounded-3xl bg-cream-50 p-5">
          <div class="flex items-center justify-between gap-3 text-sm text-ink-500">
            <span class="font-semibold text-forest-900">San Roque Parish Church</span>
            <span>4.8 ★</span>
          </div>
          <p class="mt-3 text-sm leading-relaxed text-ink-600">"A peaceful place with beautiful architecture. Great for a slow afternoon and local culture."</p>
        </div>
        <div class="rounded-3xl bg-cream-50 p-5">
          <div class="flex items-center justify-between gap-3 text-sm text-ink-500">
            <span class="font-semibold text-forest-900">Macajalar Bay Boardwalk</span>
            <span>4.7 ★</span>
          </div>
          <p class="mt-3 text-sm leading-relaxed text-ink-600">"The bay is perfect at sunset. Plenty of food stalls and a nice seaside breeze make it a top spot."</p>
        </div>
      </div>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <h2 class="font-serif text-2xl font-medium text-forest-900">Gallery details</h2>
      <ul class="mt-6 space-y-4 text-sm text-ink-600">
        <li class="flex gap-3 rounded-3xl bg-cream-50 p-4">
          <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-sage-100 text-forest-900">01</span>
          <div>
            <p class="font-semibold text-forest-900">Preview cards for the public site.</p>
            <p class="mt-1">Each card includes a headline, description, rating, and image for a visitor-facing destination listing.</p>
          </div>
        </li>
        <li class="flex gap-3 rounded-3xl bg-cream-50 p-4">
          <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-sage-100 text-forest-900">02</span>
          <div>
            <p class="font-semibold text-forest-900">Sample review content built in.</p>
            <p class="mt-1">Reviews appear with each destination to highlight guest experiences and help travelers choose their next visit.</p>
          </div>
        </li>
        <li class="flex gap-3 rounded-3xl bg-cream-50 p-4">
          <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-sage-100 text-forest-900">03</span>
          <div>
            <p class="font-semibold text-forest-900">Images designed for tourism promotion.</p>
            <p class="mt-1">Use large hero media and gallery cards to communicate the region’s natural beauty and cultural offerings.</p>
          </div>
        </li>
      </ul>
    </article>
  </section>
@endsection