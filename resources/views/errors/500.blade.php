@extends('errors.layout')

@section('title', '500 - Server Error')
@section('code', '500')
@section('heading', 'Internal Server Error')
@section('code_color', 'text-rose-400')
@section('icon_bg', 'bg-rose-500/15 border border-rose-400/30 text-rose-400')

@section('icon')
  <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
  </svg>
@endsection

@section('message')
  {{ $exception->getMessage() ?: 'Something went wrong on our server. Our team has been notified.' }}
@endsection
