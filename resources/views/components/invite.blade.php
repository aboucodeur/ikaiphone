@props(['dclass' => '', 'dstyle' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('/nav_iphones.jpg');
            background-size: cover;
            background-position: center;
        }

    </style>
</head>

<body>
    <main class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
                {{ $slot }}
            </div>
        </div>
    </main>

    @include('includes.footer')
</body>

</html>
