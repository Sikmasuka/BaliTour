@props([
    'title' => null,
    'subtitle' => null,
    'portal' => null
])

@include('layouts.header', [
    'title' => $title,
    'subtitle' => $subtitle,
    'portal' => $portal
])
