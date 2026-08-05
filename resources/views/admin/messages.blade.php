@extends('admin.layout')

@section('title', 'Contact Messages')
@section('page-subtitle', 'Messages inbox')
@section('messages-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Communications</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Contact Messages</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Manage incoming messages from visitors, partners, and travel inquiries.</p>
  </section>
  <section class="grid gap-4 sm:grid-cols-2">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Open messages</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Respond quickly</h2>
      <p class="mt-3 text-sm text-ink-600">See unread contact requests and reply to customers right from the admin panel.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Message history</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Review past conversations</h2>
      <p class="mt-3 text-sm text-ink-600">Browse previous enquiries and support interactions to keep context in one place.</p>
    </article>
  </section>
@endsection
