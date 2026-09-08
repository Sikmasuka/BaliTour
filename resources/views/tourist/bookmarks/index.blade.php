@extends('tourist.layout')

@section('title', 'Bookmarks')
@section('page-subtitle', 'Bookmarks')
@section('bookmarks-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Saved</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Bookmarks</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Review places and events you have saved for later
            planning.</p>
    </section>

    <section class="grid gap-6">
        <div
            class="col-span-full flex flex-col items-center justify-center rounded-3xl border border-dashed border-cream-200 bg-white py-16 text-center shadow-xs">
            <div
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-cream-100 text-forest-900 ring-1 ring-cream-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                </svg>
            </div>
            <p class="mt-4 font-serif text-xl font-medium text-forest-900">No saved bookmarks yet</p>
            <p class="mt-1 max-w-sm text-sm text-ink-600">Browse destinations and bookmark your favorite places to revisit
                them anytime.</p>
            <a href="{{ route('destinations.index') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-forest-900 px-5 py-2.5 text-sm font-semibold text-cream-50 hover:bg-forest-800 transition shadow-xs">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Discover Places
            </a>
        </div>
    </section>
@endsection
