@extends('layout.main', ['title' => 'Tambah User'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('user.index') }}">User Management</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Akun
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">

                    <h3>Tambah Akun Petugas</h3>
                    <p class="text-subtitle text-muted">
                        Isi form untuk membuat akun petugas.
                    </p>
                </div>
            </div>
        </div>
        <section class="section col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form id="form" action="{{ route('user.store') }}" method="POST" class="form form-horizontal">
                            @csrf
                            <div class="form-body">
                                <div class="row">

                                    {{-- Form Nama --}}
                                    <div class="col-md-3">
                                        <label>Nama</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="text"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}">
                                        <div class="invalid-feedback">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Form Role --}}
                                    <div class="col-md-3">
                                        <label>Role</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('role') is-invalid @enderror"
                                                type="radio" name="role" id="inlineRadio1" value="admin"
                                                {{ old('role') == 'admin' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio1"
                                                style="font-weight: normal">Admin RDS</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('role') is-invalid @enderror"
                                                type="radio" name="role" id="inlineRadio3" value="kader_poskesdes"
                                                {{ old('role') == 'kader_poskesdes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio3"
                                                style="font-weight: normal">Kader Poskesdes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('role') is-invalid @enderror"
                                                type="radio" name="role" id="inlineRadio2" value="kader_posyandu"
                                                {{ old('role') == 'kader_posyandu' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio2"
                                                style="font-weight: normal">Kader Posyandu</label>
                                        </div>
                                    </div>

                                    {{-- Form Posyandu --}}
                                    <div class="col-md-3">
                                        <label>Posyandu</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input id="posyanduHidden" type="hidden" name="posyandu" value="">
                                        <select name="posyandu"
                                            class="form-select select2 @error('posyandu') is-invalid @enderror"
                                            id="posyanduSelect" data-placeholder="Pilih Posyandu">
                                            <option></option>
                                            @foreach ($listPosyandu as $lp)
                                                <option value="{{ $lp->id }}"
                                                    {{ old('posyandu') == $lp->id ? 'selected' : '' }}>{{ $lp->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('posyandu')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Form Username --}}
                                    <div class="col-md-3">
                                        <label for="email-horizontal">Username</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="text" id="username-input"
                                            class="form-control form-control-lg @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') }}">
                                        <div class="invalid-feedback">
                                            @error('username')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Form Password --}}
                                    <div class="col-md-3">
                                        <label>Password</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            name="password">
                                        <div class="invalid-feedback">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button id="submitBtn" type="submit"
                                            class="btn btn-primary me-3 mb-1">Simpan</button>
                                        <button id="resetButton" type="reset"
                                            class="btn btn-light-secondary me-1 mb-1 buttonReset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('jsLibraries')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('.select2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>

    <script>
        // Reset select2
        $('#resetButton').on('click', function() {
            $('#posyanduSelect').val(null).trigger('change');
        });

        // Menangani perubahan pada input radio
        document.addEventListener('DOMContentLoaded', function() {
            const radioRDS = document.getElementById('inlineRadio1');
            const radioPosyandu = document.getElementById('inlineRadio2');
            const radioPoskesdes = document.getElementById('inlineRadio3'); // Tambahkan ini
            const posyanduSelect = document.getElementById('posyanduSelect');
            const hiddenPosyandu = document.getElementById('posyanduHidden');

            // Fungsi untuk menonaktifkan atau mengaktifkan select Posyandu
            function handleRoleChange() {
                if (radioRDS.checked || radioPoskesdes.checked) { // Tambahkan kondisi untuk radioPoskesdes
                    // Reset dropdown menggunakan jQuery dan trigger 'change' event
                    $('#posyanduSelect').val(null).trigger('change');

                    // Setelah reset, disable select
                    posyanduSelect.disabled = true;
                    hiddenPosyandu.value = null; // Set hidden input ke null
                } else if (radioPosyandu.checked) {
                    posyanduSelect.disabled = false; // Mengaktifkan select
                    hiddenPosyandu.value = posyanduSelect.value; // Set hidden input ke nilai select
                }
            }

            // Event listener ketika input radio berubah
            radioRDS.addEventListener('change', handleRoleChange);
            radioPosyandu.addEventListener('change', handleRoleChange);
            radioPoskesdes.addEventListener('change', handleRoleChange); // Tambahkan ini

            // Event listener ketika select posyandu berubah
            posyanduSelect.addEventListener('change', function() {
                hiddenPosyandu.value = posyanduSelect.value; // Update hidden input dengan nilai baru
            });

            // Jalankan saat halaman pertama kali dimuat
            handleRoleChange();
        });
    </script>

    {{-- Loading Tombol Submit --}}
    <script>
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah submit default agar kita bisa menambahkan efek loading

            // Nonaktifkan tombol saat loading
            this.disabled = true;

            // Tambahkan spinner ke dalam tombol
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';


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
@endsection
