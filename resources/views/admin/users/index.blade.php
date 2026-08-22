@extends('admin.layout')

@section('title', 'Manage Users')
@section('page-subtitle', 'User management')
@section('users-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">People</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Manage Users</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">View and moderate registered users, account roles, and active sessions.</p>
  </section>
  <section class="grid gap-4 sm:grid-cols-2">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">User list</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">See accounts at a glance</h2>
      <p class="mt-3 text-sm text-ink-600">Browse active users, review their roles, and manage access levels.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Permissions</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Control admin access</h2>
      <p class="mt-3 text-sm text-ink-600">Update permissions for staff, travelers, and administrators across the site.</p>
    </article>
  </section>
@endsection
