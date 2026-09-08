@extends('admin.layout')

@section('title', 'Manage Users')
@section('page-subtitle', 'User management')
@section('users-active', 'bg-cream-50 text-forest-900 shadow-sm')

@section('content')
    <section class="mb-8 rounded-3xl bg-forest-900 p-8 text-cream-50 sm:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-300">People</p>
        <h1 class="mt-3 font-serif text-3xl font-medium sm:text-4xl">Manage Users</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-cream-100/80">View and moderate registered users, account
            roles, and active sessions.</p>
    </section>
    <section class="mt-8">
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="font-serif text-2xl font-medium text-forest-900">Registered Accounts</h2>
                <p class="mt-1 text-sm text-ink-600">Active users, tourists, and administrators.</p>
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
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-ink-900 sm:pl-6">User
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">Role
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Status</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-ink-900">
                                        Joined</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-cream-200 bg-white">
                                @forelse($users as $user)
                                    <tr class="hover:bg-cream-50/50 transition">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-ink-900 sm:pl-6">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-9 w-9 rounded-full bg-forest-900 text-cream-50 flex items-center justify-center font-bold text-xs">
                                                    {{ strtoupper(substr($user->username ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-ink-950">
                                                        {{ $user->touristProfile?->first_name ? $user->touristProfile->first_name . ' ' . $user->touristProfile->last_name : $user->username }}
                                                    </p>
                                                    <p class="text-xs text-ink-500 font-mono">&#64;{{ $user->username }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-ink-600 font-mono">
                                            {{ $user->email }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span
                                                class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-semibold {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-800' : 'bg-forest-100 text-forest-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span
                                                class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-semibold {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                                {{ ucfirst($user->status ?? 'active') }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-ink-500">
                                            {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cream-100 text-forest-800 ring-1 ring-cream-200">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                    </svg>
                                                </div>
                                                <p class="mt-3 text-base font-semibold text-ink-900">No users found</p>
                                                <p class="mt-1 max-w-sm text-xs text-ink-500">Registered users and accounts
                                                    will appear here.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (isset($users) && $users->hasPages())
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
