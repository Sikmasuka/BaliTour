@extends('errors.layout')

@section('title', '503 - Under Maintenance')
@section('code', '503')
@section('heading', 'Under Maintenance')
@section('code_color', 'text-emerald-400')
@section('icon_bg', 'bg-emerald-500/15 border border-emerald-400/30 text-emerald-400')

@section('icon')
  <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.057a4.5 4.5 0 0 0 4.387-1.472M18.75 6.75a3 3 0 0 1-3 3h-.75m0 0a3 3 0 0 1-3-3V6m3 3.75v3.75" />
  </svg>
@endsection

@section('message')
  {{ $exception->getMessage() ?: 'We are performing routine upgrades. BaliTours will be back online shortly.' }}
@endsection
