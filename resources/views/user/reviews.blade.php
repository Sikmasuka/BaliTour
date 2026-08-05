@extends('user.layout')

@section('title', 'Leave Reviews')
@section('page-subtitle', 'Leave Reviews')
@section('reviews-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Feedback</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Leave a review</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Share your experience to help other travelers make the most of their visit.</p>
  </section>

  <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200 sm:p-8">
    <form class="space-y-6">
      <div>
        <label for="place" class="block text-sm font-medium text-ink-900">Place or experience</label>
        <input id="place" type="text" placeholder="What did you review?" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none">
      </div>
      <div>
        <label for="rating" class="block text-sm font-medium text-ink-900">Rating</label>
        <select id="rating" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none">
          <option>5 - Excellent</option>
          <option>4 - Very good</option>
          <option>3 - Good</option>
          <option>2 - Fair</option>
          <option>1 - Poor</option>
        </select>
      </div>
      <div>
        <label for="comments" class="block text-sm font-medium text-ink-900">Comments</label>
        <textarea id="comments" rows="5" placeholder="Tell us what you enjoyed" class="mt-2 w-full rounded-2xl border border-cream-200 bg-cream-50 px-4 py-3 text-sm text-ink-900 focus:border-forest-700 focus:outline-none"></textarea>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="rounded-2xl bg-forest-900 px-5 py-3 text-sm font-semibold text-cream-50 hover:bg-forest-700">Submit review</button>
      </div>
    </form>
  </section>
@endsection