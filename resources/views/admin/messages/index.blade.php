@extends('admin.layout')

@section('title', 'Contact Messages')
@section('page-subtitle', 'Messages inbox')
@section('messages-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">Communications</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Contact Messages</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">Manage incoming messages from visitors, partners,
            and travel inquiries.</p>
    </section>
    <section class="mt-8">
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="font-serif text-2xl font-medium text-forest-900">Message Inbox</h2>
                <p class="mt-1 text-sm text-ink-600">Inquiries and messages submitted from the public site.</p>
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
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-ink-900 sm:pl-6">Sender
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Subject</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">Date
                                        Received</th>
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
                                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                </svg>
                                            </div>
                                            <p class="mt-3 text-base font-semibold text-ink-900">No contact messages yet</p>
                                            <p class="mt-1 max-w-sm text-xs text-ink-500">Inquiries, questions, and feedback
                                                from travelers will appear here once received.</p>
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
