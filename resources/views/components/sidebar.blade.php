@props([
    'active' => null,
    'portal' => null
])

@include('layouts.sidebar', [
    'active' => $active ?? null,
    'portal' => $portal ?? null
])
