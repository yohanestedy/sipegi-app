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
                        Isi form untuk menambah data balita.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Balita</a>
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

                                {{-- tanda wajib diisi --}}
                                {{-- <span style="color: #dc3545;">*</span> --}}

                                {{-- Form Nama Balita --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Nama Balita</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="text" id="first-name-horizontal" class="form-control" name="name"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form NIK --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 text-md-end justify-content-end mt-3">
                                        <label for="first-name-horizontal">NIK Balita</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="number" id="nik-input" class="form-control" name="nik"
                                            placeholder="">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault"
                                                style="font-weight: normal;">
                                                Ceklist jika Balita belum mempunyai NIK
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Tanggal Lahir --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Tanggal Lahir</label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <input type="date" id="first-name-horizontal" class="form-control"
                                            name="birthdate" placeholder="">
                                    </div>
                                </div>

                                {{-- Form Jenis Kelamin --}}
                                <div class="row mt-2">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Jenis Kelamin</label>
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

                                {{-- Form Nama Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Nama Orangtua</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Nama Orangtua">
                                            <option></option>
                                            <option>Sri</option>
                                            <option>Ana</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Posyandu --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Posyandu</label>
                                    </div>
                                    <div class="col-md-4 form-group mt-2">
                                        <select class="form-select select2" data-placeholder="Pilih Posyandu">
                                            <option></option>
                                            <option>Melati - Dusun 1</option>
                                            <option>Nusa Indah - Dusun 2</option>
                                            <option>Kenanga - Dusun 3</option>
                                            <option>Mawar - Dusun 4</option>
                                            <option>Dahlia - Dusun 5</option>
                                            <option>Anggrek - Dusun 6</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Anak Ke Berapa --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Anak ke berapa?</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input type="number" class="form-control" name="orderfam" placeholder="">
                                    </div>
                                </div>

                                {{-- Form BB saat Lahir --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Berat Badan saat lahir(kg)</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
                                    </div>
                                </div>

                                {{-- Form PB saat Lahir --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="first-name-horizontal">Panjang Badan saat lahir(cm)</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input type="number" id="first-name-horizontal" class="form-control"
                                            name="name" placeholder="">
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

        document.getElementById('flexCheckDefault').onchange = function() {
            var nikInput = document.getElementById('nik-input');
            if (this.checked) {
                nikInput.disabled = true;
                nikInput.value = "";
            } else {
                nikInput.disabled = false;
            }
        };
    </script>
@endsection
