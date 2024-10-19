@extends('layout.main', ['title' => 'Tambah User'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">User Management</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tambah Akun Petugas
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">

                                    {{-- Form Nama --}}
                                    <div class="col-md-3">
                                        <label for="first-name-horizontal">Nama</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="text" id="first-name-horizontal"
                                            class="form-control form-control-lg" name="name" placeholder="Nama">
                                    </div>

                                    {{-- Form Role --}}
                                    <div class="col-md-3">
                                        <label for="first-name-horizontal">Role</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="role" id="inlineRadio1"
                                                value="kader_puskesdes">
                                            <label class="form-check-label" for="inlineRadio1"
                                                style="font-weight: normal">Kader Puskesdes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="role" id="inlineRadio2"
                                                value="kader_posyandu">
                                            <label class="form-check-label" for="inlineRadio2"
                                                style="font-weight: normal">Kader Posyandu</label>
                                        </div>
                                    </div>

                                    {{-- Form Posyandu --}}
                                    <div class="col-md-3">
                                        <label for="contact-info-horizontal">Posyandu</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <select class="form-select select2" id="posyanduSelect"
                                            data-placeholder="Pilih Posyandu">
                                            <option></option>
                                            <option>Melati - Dusun 1</option>
                                            <option>Nusa Indah - Dusun 2</option>
                                            <option>Kenanga - Dusun 3</option>
                                            <option>Mawar - Dusun 4</option>
                                            <option>Dahlia - Dusun 5</option>
                                            <option>Anggrek - Dusun 6</option>
                                        </select>
                                    </div>

                                    {{-- Form Username --}}
                                    <div class="col-md-3">
                                        <label for="email-horizontal">Username</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="text" id="username-input" class="form-control form-control-lg"
                                            name="username" placeholder="Username">
                                    </div>

                                    {{-- Form Password --}}
                                    <div class="col-md-3">
                                        <label for="password-horizontal">Password</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="password" id="password-horizontal" class="form-control form-control-lg"
                                            name="password" placeholder="Password">
                                    </div>

                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-3 mb-1">Simpan</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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
        // Menangani perubahan pada input radio
        document.addEventListener('DOMContentLoaded', function() {
            const radioPuskesdes = document.getElementById('inlineRadio1');
            const radioPosyandu = document.getElementById('inlineRadio2');
            const posyanduSelect = document.getElementById('posyanduSelect');
            const emptyOption = posyanduSelect.querySelector('option[value=""]');

            // Fungsi untuk menonaktifkan atau mengaktifkan select Posyandu
            function handleRoleChange() {
                if (radioPuskesdes.checked) {

                    posyanduSelect.disabled = true;
                    posyanduSelect.value = '' // Menonaktifkan select
                } else if (radioPosyandu.checked) {
                    posyanduSelect.disabled = false; // Mengaktifkan select
                }
            }

            // Event listener ketika input radio berubah
            radioPuskesdes.addEventListener('change', handleRoleChange);
            radioPosyandu.addEventListener('change', handleRoleChange);

            // Jalankan saat halaman pertama kali dimuat
            handleRoleChange();
        });
    </script>
@endsection
