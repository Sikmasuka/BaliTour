@extends('errors.layout')

@section('title', '403 - Access Forbidden')
@section('code', '403')
@section('heading', 'Access Forbidden')
@section('code_color', 'text-amber-400')
@section('icon_bg', 'bg-amber-500/15 border border-amber-400/30 text-amber-400')

@section('icon')
  <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
  </svg>
@endsection

@section('message')
  {{ $exception->getMessage() ?: 'You do not have permission or clearance to access this destination or admin page.' }}
@endsection
