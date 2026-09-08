@extends('tourist.layout')

@section('title', 'Leave Reviews')
@section('page-subtitle', 'Leave Reviews')
@section('reviews-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Feedback</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Leave a review</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Share your experience to help other travelers
            make the most of their visit.</p>
    </section>

    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Left: Empty Reviews State -->
        <div class="lg:col-span-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
                <h2 class="font-serif text-xl font-medium text-forest-900">Your Submitted Reviews</h2>
                <p class="mt-1 text-xs text-ink-500">Reviews you have shared for destinations across Balingasag.</p>

                <div
                    class="mt-6 flex flex-col items-center justify-center rounded-2xl border border-dashed border-cream-200 bg-cream-50/50 py-12 text-center">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cream-100 text-forest-800 ring-1 ring-cream-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    </div>
                    <p class="mt-3 text-base font-medium text-forest-900">No reviews written yet</p>
                    <p class="mt-1 max-w-sm text-xs text-ink-500">You haven't submitted any reviews yet. Visit destinations
                        to share your experiences with the community.</p>
                    <a href="{{ route('destinations.index') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-forest-900 px-4 py-2 text-xs font-semibold text-cream-50 hover:bg-forest-800 transition shadow-xs">
                        Browse Destinations
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: How reviews work tip box -->
        <div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-500">Guidelines</p>
                <h3 class="mt-2 font-serif text-lg font-medium text-forest-900">Community Feedback</h3>
                <p class="mt-2 text-xs leading-relaxed text-ink-600">
                    Reviews are submitted directly on each destination's page so your ratings, photos, and feedback are
                    verified and attached to the right tourist site.
                </p>
                <div class="mt-4 border-t border-cream-100 pt-4 text-xs text-ink-500 space-y-2">
                    <p>✓ Honest and helpful feedback</p>
                    <p>✓ Highlights, pricing, and tips</p>
                    <p>✓ Moderated for visitor safety</p>
                </div>
            </div>
        </div>
    </div>
@endsection
