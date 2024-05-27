{{-- ignore appTitle --}}
@props(['dclass' => '', 'dstyle' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body>
    <main id="main-wrapper" class="main-wrapper">
        <div class="header">
            @include('includes.header')
        </div>

        <div class="app-menu">
            @include('includes.menu')
        </div>

        <div id="app-content">
            <div class="app-content-area h-100 w-100 {{ $dclass }}" style="{{ $dstyle }}">
                {{ $slot }}
            </div>
        </div>

    </main>

    @include('includes.footer')
</body>

</html>
