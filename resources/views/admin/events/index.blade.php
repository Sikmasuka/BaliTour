@extends('admin.layout')

@section('title', 'Manage Events')
@section('page-subtitle', 'Events management')
@section('events-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
  <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Content</p>
    <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Manage Events</h1>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Curate upcoming festivals, tours, and cultural programming for visitors.</p>
  </section>
  <section class="grid gap-4 sm:grid-cols-2">
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Event calendar</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Manage dates and schedules</h2>
      <p class="mt-3 text-sm text-ink-600">Set event times, descriptions, and featured activities for the public calendar.</p>
    </article>
    <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-cream-200">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Event details</p>
      <h2 class="mt-3 font-serif text-xl font-medium text-forest-900">Edit event content</h2>
      <p class="mt-3 text-sm text-ink-600">Update event listings with photos, location info, availability, and visitor notes.</p>
    </article>
  </section>

  {{-- Events CRUD Section --}}
  <section class="mt-8">
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h2 class="font-serif text-2xl font-medium text-forest-900">All Events</h2>
        <p class="mt-1 text-sm text-ink-600">A list of all the events in your database.</p>
      </div>
      <button id="openPanelBtn" type="button"
        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-forest-900 px-5 py-3 text-sm font-semibold text-cream-50 shadow-sm transition-colors hover:bg-forest-800 focus:outline-none focus:ring-2 focus:ring-forest-500 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-ml-1 h-5 w-5">
          <path fill-rule="evenodd"
            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
            clip-rule="evenodd" />
        </svg>
        Add Event
      </button>
    </div>

    {{-- Events Table --}}
    <div class="mt-6 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden rounded-3xl shadow-sm ring-1 ring-cream-200">
            <table class="min-w-full divide-y divide-cream-200">
              <thead class="bg-white">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-ink-900 sm:pl-6">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">Date</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">Status</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-cream-200 bg-white">
                {{-- This is a placeholder. You should loop through your events from the controller. --}}
                <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-ink-900 sm:pl-6">Nyepi Festival</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-ink-600">March 11, 2027</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-ink-600"><span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Published</span></td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"><a href="#" class="text-forest-600 hover:text-forest-900">Edit<span class="sr-only">, Nyepi Festival</span></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Add/Edit Modal --}}
    <div id="eventsModal" class="relative z-10 hidden" aria-labelledby="panelTitle" role="dialog" aria-modal="true">
      <div id="eventsModalOverlay" class="fixed inset-0 bg-forest-900/40 opacity-0 transition-opacity duration-300" aria-hidden="true"></div>

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div id="eventsPanel" class="pointer-events-auto w-screen max-w-xl transform translate-x-full transition-transform duration-300 ease-in-out">
              <div class="flex h-full flex-col bg-cream-50 shadow-2xl">
                <div class="flex items-center justify-between border-b border-cream-200 bg-white px-6 py-5">
                  <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-ink-600">Event</p>
                    <h2 id="panelTitle" class="mt-1 font-serif text-2xl font-medium text-forest-900">Add New Event</h2>
                  </div>
                  <button id="closePanelBtn" type="button" aria-label="Close panel" class="rounded-full p-2 text-ink-600 hover:bg-cream-100">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
                  </button>
                </div>

                <form action="#" method="POST" class="flex-1 space-y-7 overflow-y-auto px-6 py-6">
                  @csrf
                  <div class="space-y-4">
                    <div>
                      <label for="event-name" class="mb-1.5 block text-sm font-medium text-ink-900">Event Name</label>
                      <input type="text" name="event-name" id="event-name" placeholder="e.g. Nyepi Festival"
                        class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700 focus:outline-none">
                    </div>

                    <div>
                      <label for="event-date" class="mb-1.5 block text-sm font-medium text-ink-900">Event Date</label>
                      <input type="date" name="event-date" id="event-date"
                        class="w-full rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700 focus:outline-none">
                    </div>

                    <div>
                      <label for="event-description" class="mb-1.5 block text-sm font-medium text-ink-900">Description</label>
                      <textarea rows="4" name="event-description" id="event-description" placeholder="Write a few sentences about the event."
                        class="w-full resize-none rounded-xl border border-cream-200 bg-white px-3.5 py-2.5 text-sm focus:border-forest-700 focus:outline-none"></textarea>
                    </div>
                  </div>
                  
                  <div>
                    <label for="event-image-label" class="mb-1.5 block text-sm font-medium text-ink-900">Event Image</label>
                    <div id="imagePreviewContainer" class="hidden w-full">
                      <div class="relative mb-2 w-fit">
                        <img id="imagePreview" src="" alt="Event image preview" class="h-40 w-auto rounded-xl object-cover">
                        <button id="removeImageBtn" type="button" aria-label="Remove image" class="absolute -right-2 -top-2 rounded-full bg-white p-1 shadow-md">
                          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg>
                        </button>
                      </div>
                    </div>
                    <div id="imageUploadBox" class="flex cursor-pointer items-center justify-center rounded-xl border-2 border-dashed border-cream-300 bg-white px-6 py-10">
                      <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-ink-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.5-3.5a4 4 0 00-5.66 0L17 30.34m0 0l-3.5-3.5a4 4 0 00-5.66 0l-2.83 2.83" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <p class="mt-3 text-sm text-ink-600"><span class="font-semibold text-forest-700">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-ink-500">PNG, JPG, GIF up to 10MB</p>
                        <input id="event-image" name="event-image" type="file" class="hidden" accept="image/*">
                      </div>
                    </div>
                  </div>

                  <div class="flex items-center justify-between gap-3 border-t border-cream-200 bg-white px-6 py-4">
                    <button id="cancelModalBtn" type="button" class="rounded-2xl border border-cream-200 bg-white px-5 py-2.5 text-sm font-semibold text-ink-900 hover:bg-cream-100">Cancel</button>
                    <button type="submit" class="rounded-2xl bg-forest-900 px-5 py-2.5 text-sm font-semibold text-cream-50 shadow-sm hover:bg-forest-700">Save Event</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
(function () {
  const openPanelBtn = document.getElementById('openPanelBtn');
  const closePanelBtn = document.getElementById('closePanelBtn');
  const cancelModalBtn = document.getElementById('cancelModalBtn');
  const eventsModal = document.getElementById('eventsModal');
  const eventsModalOverlay = document.getElementById('eventsModalOverlay');
  const eventsPanel = document.getElementById('eventsPanel');
  
  // Image upload elements
  const imageUploadBox = document.getElementById('imageUploadBox');
  const imageInput = document.getElementById('event-image');
  const imagePreviewContainer = document.getElementById('imagePreviewContainer');
  const imagePreview = document.getElementById('imagePreview');
  const removeImageBtn = document.getElementById('removeImageBtn');

  function openPanel() {
    eventsModal.classList.remove('hidden');
    requestAnimationFrame(() => {
      eventsModalOverlay.classList.add('opacity-100');
      eventsPanel.classList.remove('translate-x-full');
    });
  }

  function closePanel() {
    eventsModalOverlay.classList.remove('opacity-100');
    resetImageUpload();
    eventsPanel.classList.add('translate-x-full');
    eventsPanel.addEventListener('transitionend', handleTransitionEnd, { once: true });
  }

  function handleTransitionEnd() {
    eventsModal.classList.add('hidden');
  }

  function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imageUploadBox.classList.add('hidden');
        imagePreviewContainer.classList.remove('hidden');
      }
      reader.readAsDataURL(file);
    }
  }

  function resetImageUpload() {
    imageInput.value = ''; // Clear the file input
    imagePreview.src = '';
    imageUploadBox.classList.remove('hidden');
    imagePreviewContainer.classList.add('hidden');
  }

  // Event listeners for image upload
  imageUploadBox.addEventListener('click', () => imageInput.click());
  imageInput.addEventListener('change', handleImageUpload);
  removeImageBtn.addEventListener('click', resetImageUpload);

  // Event listeners for panel
  openPanelBtn.addEventListener('click', openPanel);
  closePanelBtn.addEventListener('click', closePanel);
  cancelModalBtn.addEventListener('click', closePanel);
  eventsModalOverlay.addEventListener('click', closePanel);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !eventsModal.classList.contains('hidden')) {
      closePanel();
    }
  });
})();
</script>
@endpush
