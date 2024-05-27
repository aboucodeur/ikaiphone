@props(['title' => 'Mon menu', 'url' => '/'])

@php
    // Celui du navigateur
    $uri = request()->path();

    // nous devons ecarter le /
    if ($url == $uri) {
        $active_class = 'active menu-bg text-white rounded m-1';
    } else {
        $active_class =
            Str::startsWith('/' . $uri, $url) && Str::length($url) > 1 ? 'active menu-bg text-white rounded m-1' : '';
    }
@endphp

<li class="nav-item mb-0 m-0 p-0">
    <a class="nav-link has-arrow text-white {{ $active_class }}" href="{{ $url }}">
        {{-- Icon as slot --}}
        {{ $slot }}
        <strong>{{ $title }}</strong>
    </a>
</li>
