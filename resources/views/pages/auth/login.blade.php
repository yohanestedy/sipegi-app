<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiPeGi Selorejo</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/static/images/logo/sipegi-favicon.svg') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app.css') }}">
    {{-- <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/app-dark.css') }}"> --}}
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/fontawesome/css/all.css') }}">
</head>

<body>
    {{-- <script src="{{ asset('assets/static/js/initTheme.js') }}"></script> --}}
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('assets/static/images/logo/sipegi-logo.svg') }}"></a>
                    </div>

                    {{-- <h1 class="auth-title">Masuk</h1> --}}
                    <p style="text-align: center;" class="auth-subtitle mb-2">Sipegi adalah aplikasi untuk menilai gizi
                        balita di Desa Selorejo</p>



                    <form id="form" action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="username" type="text"
                                class="form-control form-control-xl @if (session('error')) is-invalid @endif @error('username') is-invalid @enderror"
                                placeholder="Username" value="{{ old('username') }}">
                            <div class="form-control-icon">
                                <i class="fa-duotone fa-solid fa-circle-user mt-2 ms-1"></i>
                            </div>
                            <div class="invalid-feedback">
                                @error('username')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="password" type="password"
                                class="form-control form-control-xl @if (session('error')) is-invalid @endif @error('password') is-invalid @enderror"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="fa-duotone fa-solid fa-shield-keyhole mt-2 ms-1"></i>
                            </div>
                            <div class="invalid-feedback">
                                @error('password')
                                    {{ $message }}
                                @enderror

                                @if (session('error'))
                                    {{ session('error') }}
                                @endif
                            </div>

                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" name="remember" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Ingat saya
                            </label>
                        </div>
                        <button id="submitBtn"
                            class="btn btn-primary btn-block btn-lg shadow-lg mt-5 submitBtn">Masuk</button>

                    </form>

                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah submit default agar kita bisa menambahkan efek loading

        // Nonaktifkan tombol saat loading
        this.disabled = true;

        // Tambahkan spinner ke dalam tombol
        this.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Masuk...';


        // Setelah efek loading, lanjutkan dengan submit form
        setTimeout(() => {
            // Kirim form secara manual setelah animasi loading selesai
            document.getElementById('form').submit();
            this.innerHTML = 'Masuk';
            this.disabled = false;

        }, 700);


        // Sesuaikan durasi loading (misalnya 500 ms)
    });
</script>

{{-- Toast Sweatalert2 --}}
@if (session('successToast'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: "{{ session('successToast') }}"
        });
    </script>
@elseif (session('errorToast'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "{{ session('errorToast') }}"
        });
    </script>
@endif


</html>
