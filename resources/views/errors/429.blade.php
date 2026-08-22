@extends('errors.layout')

@section('title', '429 - Too Many Requests')
@section('code', '429')
@section('heading', 'Too Many Requests')
@section('code_color', 'text-amber-400')
@section('icon_bg', 'bg-amber-500/15 border border-amber-400/30 text-amber-400')

@section('icon')
  <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
  </svg>
@endsection

@section('message')
  {{ $exception->getMessage() ?: 'Too many actions sent in a short time. Please wait a moment and try again.' }}
@endsection
