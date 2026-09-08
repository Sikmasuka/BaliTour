@extends('tourist.layout')

@section('title', 'Edit Profile')
@section('page-subtitle', 'Edit Profile')
@section('edit-profile-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Account</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Edit Profile</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Update your contact details, preferences, and
            traveler profile.</p>
    </section>

    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
        <form method="POST" action="#" class="space-y-6">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-ink-900">First name</label>
                    <input id="first_name" name="first_name" type="text"
                        value="{{ old('first_name', auth()->user()->touristProfile?->first_name ?? (auth()->user()->username ?? '')) }}"
                        placeholder="Enter first name"
                        class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-ink-900">Last name</label>
                    <input id="last_name" name="last_name" type="text"
                        value="{{ old('last_name', auth()->user()->touristProfile?->last_name ?? '') }}"
                        placeholder="Enter last name"
                        class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white focus:outline-none">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="email" class="block text-sm font-medium text-ink-900">Email address</label>
                    <input id="email" name="email" type="email"
                        value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="name@example.com"
                        class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label for="mobile_number" class="block text-sm font-medium text-ink-900">Mobile number</label>
                    <input id="mobile_number" name="mobile_number" type="tel"
                        value="{{ old('mobile_number', auth()->user()->touristProfile?->mobile_number ?? '') }}"
                        placeholder="+63 9XX XXX XXXX"
                        class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white focus:outline-none">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="city_municipality" class="block text-sm font-medium text-ink-900">City /
                        Municipality</label>
                    <input id="city_municipality" name="city_municipality" type="text"
                        value="{{ old('city_municipality', auth()->user()->touristProfile?->city_municipality ?? '') }}"
                        placeholder="e.g. Balingasag"
                        class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label for="province" class="block text-sm font-medium text-ink-900">Province</label>
                    <input id="province" name="province" type="text"
                        value="{{ old('province', auth()->user()->touristProfile?->province ?? '') }}"
                        placeholder="e.g. Misamis Oriental"
                        class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:bg-white focus:outline-none">
                </div>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('user.dashboard') }}"
                    class="rounded-2xl border border-cream-200 bg-white px-5 py-3 text-center text-sm font-semibold text-ink-900 hover:bg-cream-100 transition">Cancel</a>
                <button type="submit"
                    class="rounded-2xl bg-forest-900 px-5 py-3 text-sm font-semibold text-cream-50 hover:bg-forest-700 transition">Save
                    Changes</button>
            </div>
        </form>
    </section>
@endsection
