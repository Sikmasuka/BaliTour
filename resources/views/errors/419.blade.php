@extends('errors.layout')

@section('title', '419 - Page Expired')
@section('code', '419')
@section('heading', 'Session Expired')
@section('code_color', 'text-amber-400')
@section('icon_bg', 'bg-amber-500/15 border border-amber-400/30 text-amber-400')

@section('icon')
  <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
  </svg>
@endsection

@section('message')
  {{ $exception->getMessage() ?: 'Your session security token has timed out. Please refresh the page and try again.' }}
@endsection
