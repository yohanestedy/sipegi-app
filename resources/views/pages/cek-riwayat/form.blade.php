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
        <div class="col-lg-4 col-md-6 col-sm-11">
            <div class="card shadow p-4 border-0">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/static/images/logo/sipegi-logo.svg') }}" width="150" class="mb-4">
                    <h5 class="fw-bold">Cek Riwayat Gizi Balita</h5>
                    <small class="text-muted mb-0" style="font-size: 0.75em;"><i>Jika belum memiliki NIK, tanyakan Kode
                            Balita ke Kader Posyandu / RDS.</i></small>
                </div>

                <form action="{{ route('riwayat.cek') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="kode_balita" class="form-label">NIK atau Kode Balita</label>
                        <input type="text" name="kode_balita" id="kode_balita"
                            class="form-control @if (session('error')) is-invalid @endif @error('kode_balita') is-invalid @enderror"
                            placeholder="Masukkan NIK atau Kode Balita" value="{{ old('kode_balita') }}">
                        @error('kode_balita')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <small class="text-muted"><i>(Pilih tanggal)</i></small>
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
