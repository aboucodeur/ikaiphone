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
                {{-- <div class="bg-primary pt-10 pb-21 mt-n6 mx-n4"></div> --}}
                {{-- <div class="container-fluid mt-n22 "> --}}
                {{-- @yield('main') --}}
                {{-- slot : append layout --}}
                {{ $slot }}
            </div>
        </div>

    </main>

    @include('includes.footer')
</body>

</html>
