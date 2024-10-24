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

                    <h3>Tambah Data Orangtua</h3>
                    <p class="text-subtitle text-muted">
                        Isi form untuk menambah data orangtua.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('orangtua.index') }}">Orangtua</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tambah Data Orangtua
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

                                {{-- Form NIK Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">NIK Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control" name="name"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form Nama Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Nama Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="text" id="first-name-horizontal" class="form-control" name="name"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form Telp/HP Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Telp/HP Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control" name="name"
                                            placeholder="">
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
                                            <option>SUMBER MULYO</option>
                                            <option>SIDODADI</option>
                                            <option>SUKOREJO</option>
                                            <option>SUMBER RAHAYU</option>
                                            <option>SIDOREJO</option>
                                            <option>SUKO MAKMUR</option>
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
