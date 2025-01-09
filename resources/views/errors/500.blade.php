<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Sipegi</title>
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
                    <img class="img-error" src="{{ asset('assets/compiled/svg/error-500.svg') }}" alt="System Error">
                    <h1 class="error-title">System Error</h1>
                    <p class="fs-5 text-gray-600">The website is currently unaivailable. Try again later or contact the
                        developer.</p>
                    <a href="{{ route('home') }} class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
                </div>
            </div>
        </div>


    </div>
</body>

</html>
