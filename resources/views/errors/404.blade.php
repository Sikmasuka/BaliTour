@extends('errors.layout')

@section('title', '404 - Destination Not Found')
@section('code', '404')
@section('heading', 'Destination Not Found')
@section('code_color', 'text-emerald-400')
@section('icon_bg', 'bg-emerald-500/15 border border-emerald-400/30 text-emerald-400')

@section('icon')
  <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
  </svg>
@endsection

@section('message')
  {{ $exception->getMessage() ?: 'The attraction, travel guide, or page you are looking for might have been moved or does not exist.' }}
@endsection
