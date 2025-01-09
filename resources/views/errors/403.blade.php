<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Sipegi</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/static/images/logo/sipegi-favicon.svg') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/error.css') }}">
</head>

<body>
    {{-- <script src="assets/static/js/initTheme.js"></script> --}}
    <div id="error">


        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/compiled/svg/error-403.svg') }}" alt="Forbidden">
                    <h1 class="error-title">Akses Ditolak</h1>
                    <p class="fs-5 text-gray-600">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                    <a href="{{ route('home') }}" class="btn btn-lg btn-outline-primary mt-3">Kembali ke
                        Dashboard</a>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
