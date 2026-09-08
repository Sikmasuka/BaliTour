@extends('tourist.layout')

@section('title', 'Travel List')
@section('page-subtitle', 'Travel List')
@section('booking-history-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">History</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Travel List</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Review your completed and upcoming travel list
            items in one place.</p>
    </section>

    <section class="space-y-4">
        <div
            class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-cream-200 bg-white py-16 text-center shadow-xs">
            <div
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-cream-100 text-forest-900 ring-1 ring-cream-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
            </div>
            <p class="mt-4 font-serif text-xl font-medium text-forest-900">Your travel list is empty</p>
            <p class="mt-1 max-w-sm text-sm text-ink-600">You haven't scheduled any destinations or upcoming trips yet.</p>
            <a href="{{ route('destinations.index') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-forest-900 px-5 py-2.5 text-sm font-semibold text-cream-50 hover:bg-forest-800 transition shadow-xs">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Explore Destinations
            </a>
        </div>
    </section>
@endsection
