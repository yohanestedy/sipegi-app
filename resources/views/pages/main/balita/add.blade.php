@extends('layout.main', ['title' => 'Tambah Data Balita'])

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

                    <h3>Tambah Data Balita</h3>
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
                                Tambah Data Balita
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal">
                            <div class="form-body">
                                {{-- Form Posyandu --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Posyandu <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Posyandu">
                                            <option></option>
                                            <option>Melati</option>
                                            <option>Nusa Indah</option>
                                            <option>Kenanga</option>
                                            <option>Mawar</option>
                                            <option>Dahlia</option>
                                            <option>Anggrek</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Anak Ke Berapa --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Anak ke berapa? <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <input type="number" class="form-control" name="orderfam" placeholder="">
                                    </div>
                                </div>

                                {{-- Form Tanggal Lahir --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Tanggal Lahir <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <input type="date" id="first-name-horizontal" class="form-control"
                                            name="birthdate" placeholder="">
                                    </div>
                                </div>

                                {{-- Form Jenis Kelamin --}}
                                <div class="row mt-2">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Jenis Kelamin <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1"
                                                style="font-weight: normal;">
                                                Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2"
                                                style="font-weight: normal;">
                                                Perempuan
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Nomor KK  --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Nomor KK <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control" name="kk"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form NIK --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 text-md-end justify-content-end mt-3">
                                        <label for="first-name-horizontal">NIK Balita <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control" name="nik"
                                            placeholder="">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault"
                                                style="font-weight: normal;">
                                                Ceklist jika Balita belum mempunyai NIK
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Nama Balita --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Nama Balita <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="text" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>

                                {{-- Form BB saat Lahir --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Berat Badan saat lahir(kg) <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>

                                {{-- Form PB saat Lahir --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Panjang Badan saat lahir(cm) <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>

                                {{-- Form Nama Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Nama Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="text" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>
                                {{-- Form NIK Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">NIK Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>
                                {{-- Form NIK Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Telp/HP Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>
                                {{-- Form Provinsi --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Provinsi <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Provinsi">
                                            <option></option>
                                            <option selected>Lampung</option>
                                            <option>Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Kabupaten --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Kabupaten <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Kabupaten">
                                            <option></option>
                                            <option selected>Lampung Timur</option>
                                            <option>Metro</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Kecamatan --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Kecamatan <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Kecamatan">
                                            <option></option>
                                            <option selected>Batanghari</option>
                                            <option>Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Desa --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Desa <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Desa">
                                            <option></option>
                                            <option selected>Selorejo</option>
                                            <option>Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Dusun --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Dusun <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Dusun">
                                            <option></option>
                                            <option>Sumber Mulyo</option>
                                            <option>Sidodadi</option>
                                            <option>Sukorejo</option>
                                            <option>Sumber Rahayu</option>
                                            <option>Sidoreo</option>
                                            <option>Suko Makmur</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form RT --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">RT <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih RT">
                                            <option></option>
                                            <option>001</option>
                                            <option>002</option>
                                            <option>003</option>
                                            <option>004</option>
                                            <option>005</option>
                                            <option>006</option>
                                            <option>007</option>
                                            <option>008</option>
                                            <option>009</option>
                                            <option>010</option>
                                            <option>011</option>
                                            <option>012</option>
                                            <option>013</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form RW --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">RW <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih RW">
                                            <option></option>
                                            <option>001</option>
                                            <option>002</option>
                                            <option>003</option>
                                            <option>004</option>
                                            <option>005</option>
                                            <option>006</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Alamat Lengkap --}}
                                <div class="row d-flex mb-3 ">
                                    <div class="col-md-4 mt-2 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Alamat Lengkap <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>

                                {{-- Tombol Simpan --}}
                                <div class="col-sm-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary me-3 mb-1">Simpan</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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
@endsection
