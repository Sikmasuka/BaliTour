@extends('tourist.layout')

@section('title', 'Edit Profile')
@section('page-subtitle', 'Edit Profile')
@section('edit-profile-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Account</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Edit Profile</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Update your contact details, preferences, and traveler profile.</p>
  </section>

  <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
    <form class="space-y-6">
      <div>
        <label for="full-name" class="block text-sm font-medium text-ink-900">Full name</label>
        <input id="full-name" type="text" value="Maria Santos" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none">
      </div>
      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label for="email" class="block text-sm font-medium text-ink-900">Email</label>
          <input id="email" type="email" value="maria@example.com" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none">
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-ink-900">Phone</label>
          <input id="phone" type="tel" value="+63 912 345 6789" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none">
        </div>
      </div>
      <div>
        <label for="preferences" class="block text-sm font-medium text-ink-900">Travel preferences</label>
        <textarea id="preferences" rows="4" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none">Beach, culture, food tours</textarea>
      </div>
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
        <button type="button" class="rounded-2xl border border-cream-200 bg-white px-5 py-3 text-sm font-semibold text-ink-900 hover:bg-cream-100">Cancel</button>
        <button type="submit" class="rounded-2xl bg-forest-900 px-5 py-3 text-sm font-semibold text-cream-50 hover:bg-forest-700">Save Changes</button>
      </div>
    </form>
  </section>
@endsection
