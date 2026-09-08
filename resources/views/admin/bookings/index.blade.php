@extends('admin.layout')

@section('title', 'Manage Bookings')
@section('page-subtitle', 'Booking management')
@section('bookings-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Operations</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Manage Bookings</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Track reservations, confirmations, and booking
            workflows across the site.</p>
    </section>
    <section class="mt-8">
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="font-serif text-2xl font-medium text-forest-900">All Reservations & Visit Plans</h2>
                <p class="mt-1 text-sm text-ink-600">Track scheduled tours and destination visits.</p>
            </div>
        </div>

        <div class="mt-6 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-3xl shadow-sm ring-1 ring-cream-200">
                        <table class="min-w-full divide-y divide-cream-200">
                            <thead class="bg-white">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-ink-900 sm:pl-6">Guest
                                        / Tourist</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Destination</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Planned Date</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Group Size</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-cream-200 bg-white">
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cream-100 text-forest-800 ring-1 ring-cream-200">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                                </svg>
                                            </div>
                                            <p class="mt-3 text-base font-semibold text-ink-900">No reservations or visit
                                                plans found</p>
                                            <p class="mt-1 max-w-sm text-xs text-ink-500">When visitors schedule visit plans
                                                or book tours, they will appear in this table.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
