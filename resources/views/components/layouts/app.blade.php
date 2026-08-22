@props([
    'title' => null,
    'subtitle' => null,
    'portal' => null,
    'active' => null
])

@include('layouts.app', [
    'title' => $title,
    'subtitle' => $subtitle,
    'portal' => $portal,
    'active' => $active,
    'slot' => $slot ?? null
])
