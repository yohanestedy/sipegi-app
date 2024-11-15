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
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Michroma&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet"> --}}


    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app-dark.css') }}" />
    {{-- <link rel="stylesheet" href="https://atugatran.github.io/FontAwesome6Pro/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/assets/fontawesome/css/all.css') }}">
    <style>
        body {

            font-family: "Nunito", sans-serif !important;

        }
    </style>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // SweetAlert untuk konfirmasi penghapusan
            $(".swal-logout").click(function(event) {
                event.preventDefault();

                let form = $(this).closest("#logout-form");

                Swal.fire({
                    title: "Keluar Aplikasi?",
                    text: "Anda harus login kembali untuk mengakses akun Anda.",
                    icon: "warning", // Ikon ini menandakan peringatan sebelum logout
                    showCancelButton: true,
                    confirmButtonColor: "#d33", // Warna merah untuk konfirmasi logout
                    cancelButtonColor: "#9c9c9c", // Warna abu-abu untuk tombol batal
                    confirmButtonText: "Ya, Keluar",
                    cancelButtonText: "Batal",
                }).then((willLogout) => {
                    if (willLogout.isConfirmed) {
                        form.submit(); // Submit form untuk logout
                    }
                });

            });



        });
    </script>

    {{-- Js Tambahan jika di perlukan --}}
    @yield('jsLibraries')


</body>

</html>
