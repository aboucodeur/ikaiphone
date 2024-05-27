@props(['dclass' => '', 'dstyle' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body>
    {{ $slot }}
    @include('includes.footer')
</body>

</html>
