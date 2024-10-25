<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }} &mdash; SiPeGi Selorejo</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/static/images/logo/sipegi-favicon.svg') }}">

    {{-- CSS Tambahan jika di perlukan --}}
    @yield('cssLibraries')

    {{-- Default CSS --}}
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app-dark.css') }}" />
    {{-- <link rel="stylesheet" href="https://atugatran.github.io/FontAwesome6Pro/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/assets/fontawesome/css/all.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">

        {{-- SIDEBAR --}}
        @include('include.sidebar')


        {{-- MAINCONTENT + NAVBAR --}}
        <div id="main">

            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            {{-- HEADER ATAS --}}
            {{-- @include('include.header') --}}

            {{-- MAIN CONTENT --}}
            {{-- <div id="main-content" style="min-height: 100vh"> --}}

            {{-- <div id="main-content">
                @yield('mainContent')
            </div> --}}

            @yield('mainContent')


            {{-- FOOTER --}}
            @include('include.footer')
        </div>
    </div>

    {{-- Default Js --}}
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    {{-- Js Tambahan jika di perlukan --}}
    @yield('jsLibraries')


</body>

</html>
