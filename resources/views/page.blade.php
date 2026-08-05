@extends('layouts.app')

@section('content')
  <span class="eyebrow">{{ $eyebrow ?? 'BaliTours' }}</span>
  <h1>{{ $heading ?? $title }}</h1>
  <p class="intro">{{ $intro ?? 'This section is scaffolded with simple placeholder content so you can expand it into a full page later.' }}</p>

  @if(!empty($cards))
    <div class="item-grid">
      @foreach($cards as $card)
        <article class="card">
          <h2>{{ $card['title'] }}</h2>
          <p>{{ $card['description'] }}</p>
          @if(!empty($card['link']))
            <p><a href="{{ $card['link'] }}">Explore</a></p>
          @endif
        </article>
      @endforeach
    </div>
  @endif

  @if(!empty($note))
    <p class="note">{{ $note }}</p>
  @endif
@endsection
