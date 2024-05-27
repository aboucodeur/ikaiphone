@props(['title' => 'Submenu', 'subs' => []])

<li class="nav-item">
    <a class="nav-link text-white has-arrow" href="#!" data-bs-toggle="collapse"
        data-bs-target="#{{ \Illuminate\Support\Str::slug($title) }}" aria-expanded="false"
        aria-controls="{{ \Illuminate\Support\Str::slug($title) }}">
        {{ $slot }}
        {{ $title }}
    </a>

    <div id="{{ \Illuminate\Support\Str::slug($title) }}" class="collapse show" data-bs-parent="#sideNavbar">
        <ul class="nav flex-column">
            @foreach ($subs as $item)
                @php
                    $uri = request()->path();
                    $active_class = $uri == $item['url'] ? 'active' : '';
                @endphp
                <li class="nav-item">
                    <a class="nav-link text-white {{ $active_class }}" href="{{ $item['url'] }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
