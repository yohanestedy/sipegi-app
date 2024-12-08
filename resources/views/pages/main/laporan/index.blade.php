@extends('layout.main', ['title' => 'Laporan'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- CDN untuk monthSelectPlugin -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.css" rel="stylesheet">
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="#">Laporan</a>
            </li>
            {{-- <li class="breadcrumb-item active" aria-current="page">
                Data Pengukuran Balita
            </li> --}}
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan</h3>
                    <p class="text-subtitle text-muted">halaman laporan untuk mengekspor data.</p>
                </div>

            </div>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ekspor Pengukuran Balita</h4>
                </div>
                <div class="card-body">

                    <form method="GET" action="{{ route('laporan.export-pengukuranbalita') }}"
                        class="form form-horizontal">
                        <div class="row">
                            <div class="col-12 col-md-5 mb-3">
                                <select name="posyandu_id" id="posyandu" class="form-select "
                                    data-placeholder="Pilih Posyandu" required>
                                    <option selected disabled value="">--Pilih Posyandu--</option>
                                    <option value="">Semua Posyandu</option>
                                    <option value="1">Melati / Sumber Mulyo</option>
                                    <option value="2">Nusa Indah / Sidodadi</option>
                                    <option value="3">Kenanga / Sukorejo</option>
                                    <option value="4">Mawar / Sumber Rahayu</option>
                                    <option value="5">Dahlia / Sidorejo</option>
                                    <option value="6">Anggrek / Suko Makmur</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-5 mb-3">

                                <input id="periode" name="periode" type="text" class="form-control"
                                    placeholder="Pilih Bulan dan Tahun" />
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-file-excel"></i>
                                    Export</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ekspor Daftar Balita</h4>
                </div>
                <div class="card-body">

                    <form method="GET" action="{{ route('laporan.export-pengukuranbalita') }}"
                        class="form form-horizontal">
                        <div class="row">
                            <div class="col-12 col-md-5 mb-3">
                                <select name="posyandu_id" id="posyandu" class="form-select "
                                    data-placeholder="Pilih Posyandu" required>
                                    <option selected disabled value="">--Pilih Posyandu--</option>
                                    <option value="">Semua Posyandu</option>
                                    <option value="1">Melati / Sumber Mulyo</option>
                                    <option value="2">Nusa Indah / Sidodadi</option>
                                    <option value="3">Kenanga / Sukorejo</option>
                                    <option value="4">Mawar / Sumber Rahayu</option>
                                    <option value="5">Dahlia / Sidorejo</option>
                                    <option value="6">Anggrek / Suko Makmur</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-5 mb-3">

                                <input id="periode" name="periode" type="text" class="form-control"
                                    placeholder="Pilih Bulan dan Tahun" />
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-file-excel"></i>
                                    Export</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </section>
    @endsection
    @section('jsLibraries')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
        <script>
            flatpickr("#periode", {
                "locale": "id",
                altInput: true,
                plugins: [
                    new monthSelectPlugin({

                        shorthand: true,
                        dateFormat: "m.y",
                        altFormat: "F Y",

                    }),
                ],
            });

            $('.select2').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
            });
        </script>
    @endsection
