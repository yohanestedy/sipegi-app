<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Riwayat Gizi - SiPeGi Selorejo</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/static/images/logo/sipegi-favicon.svg') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/fontawesome/css/all.css') }}">
    <style>
        body {
            background-color: #F2F7FF;
        }

        #auth {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card {
            border-radius: 1rem;
        }

        @media (max-width: 576px) {
            .card {
                padding: 1.5rem !important;
            }
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="col-lg-5 col-md-6 col-sm-10">
            <div class="card shadow p-4 border-0">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/static/images/logo/sipegi-logo.svg') }}" width="150" class="mb-2">
                    <h5 class="fw-bold">Cek Riwayat Gizi Balita</h5>
                    <p class="text-muted mb-0">Masukkan NIK dan Tanggal Lahir Balita</p>
                </div>

                <form action="{{ route('riwayat.cek') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nik" class="form-label">NIK Balita</label>

                        <input type="number" name="nik" id="nik"
                            class="form-control @if (session('error')) is-invalid @endif @error('nik') is-invalid @enderror"
                            placeholder="Masukkan NIK balita" value="{{ old('nik') }}">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <small class="text-muted"><i>contoh: 08/05/2023</i></small>
                        <input type="date" name="tgl_lahir" id="tgl_lahir"
                            class="form-control @if (session('error')) is-invalid @endif @error('tgl_lahir') is-invalid @enderror"
                            value="{{ old('tgl_lahir') }}">
                        @error('tgl_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (session('error'))
                            <div class="invalid-feedback">{{ session('error') }}</div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> Cek Riwayat
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
