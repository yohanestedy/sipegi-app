@extends('layout.main', ['title' => 'Standar Pertumbuhan Anak'])

@section('cssLibraries')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/table-datatable-jquery.css') }}">
    <style>
        /* Mengatur padding untuk semua <td> dalam tabel dengan ID 'tableUser' */
        table.dataTable td {
            padding: 7px 7px !important;
            white-space: nowrap !important;

            /* Ubah nilai sesuai kebutuhan */
        }
    </style>
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="#">Master Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Standar Pertumbuhan Anak
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Standar Pertumbuhan Anak</h3>
                    <p class="text-subtitle text-muted">Lihat standar sesuai kategori.</p>
                </div>

            </div>
        </div>
        <section class="section">


            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">
                        <div class="row">

                            {{-- TAB UTAMA --}}
                            <div class="col-12 col-md-3 mb-4 medium-text">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-BB/U-tab" data-bs-toggle="pill"
                                        href="#v-pills-BB/U" role="tab" aria-controls="v-pills-BB/U"
                                        aria-selected="true">Berat Badan / Umur</a>
                                    <a class="nav-link" id="v-pills-TB/U-tab" data-bs-toggle="pill" href="#v-pills-TB/U"
                                        role="tab" aria-controls="v-pills-TB/U" aria-selected="true">Tinggi
                                        Badan /
                                        Umur</a>
                                    <a class="nav-link" id="v-pills-BB/TB-tab" data-bs-toggle="pill" href="#v-pills-BB/TB"
                                        role="tab" aria-controls="v-pills-BB/TB" aria-selected="true">Berat Badan /
                                        Tinggi Badan</a>
                                    <a class="nav-link" id="v-pills-IMT/U-tab" data-bs-toggle="pill" href="#v-pills-IMT/U"
                                        role="tab" aria-controls="v-pills-IMT/U" aria-selected="true">IMT / Umur</a>
                                    <a class="nav-link" id="v-pills-LK/U-tab" data-bs-toggle="pill" href="#v-pills-LK/U"
                                        role="tab" aria-controls="v-pills-LK/U" aria-selected="true">Lingkar Kepala /
                                        Umur</a>


                                </div>
                            </div>

                            {{-- ISI TAB UTAMA --}}
                            <div class="col-12 col-md-9 medium-text">
                                <div class="tab-content" id="v-pills-tabContent">

                                    {{-- BB/U --}}
                                    <div class="tab-pane fade show active" id="v-pills-BB/U" role="tabpanel"
                                        aria-labelledby="v-pills-BB/U-tab">

                                        {{-- TAB LAKI DAN PEREMPUAN --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="BB/U/L-tab" data-bs-toggle="tab"
                                                    href="#BB/U/L" role="tab" aria-controls="BB/U/L"
                                                    aria-selected="true">Laki-laki</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="BB/U/P-tab" data-bs-toggle="tab" href="#BB/U/P"
                                                    role="tab" aria-controls="BB/U/P" aria-selected="false"
                                                    tabindex="-1">Perempuan</a>
                                            </li>
                                        </ul>

                                        {{-- ISI TAB LAKI DAN PEREMPUAN --}}
                                        <div class="tab-content" id="myTabContent">
                                            {{-- Laki-laki --}}
                                            <div class="tab-pane  active show" id="BB/U/L" role="tabpanel"
                                                aria-labelledby="BB/U/L-tab">
                                                <p class="my-2 text-center">Standar Berat Badan menurut Umur (BB/U)
                                                    Umur 0-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur (Bulan)
                                                                </th>
                                                                <th colspan="7">Berat Badan (Kg)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['bb_u_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan --}}
                                            <div class="tab-pane " id="BB/U/P" role="tabpanel"
                                                aria-labelledby="BB/U/P-tab">
                                                <p class="my-2 text-center">Standar Berat Badan menurut Umur (BB/U)
                                                    Umur 0-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Berat Badan
                                                                    (Kg)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['bb_u_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- TB/U --}}
                                    <div class="tab-pane fade" id="v-pills-TB/U" role="tabpanel"
                                        aria-labelledby="v-pills-TB/U-tab">

                                        {{-- TAB LAKI DAN PEREMPUAN --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="PB/U/L-tab" data-bs-toggle="tab"
                                                    href="#PB/U/L" role="tab" aria-controls="PB/U/L"
                                                    aria-selected="true">Laki-laki (0-24)</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="PB/U/P-tab" data-bs-toggle="tab" href="#PB/U/P"
                                                    role="tab" aria-controls="PB/U/P" aria-selected="false"
                                                    tabindex="-1">Perempuan (0-24)</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="TB/U/L-tab" data-bs-toggle="tab" href="#TB/U/L"
                                                    role="tab" aria-controls="TB/U/L" aria-selected="false">Laki-laki
                                                    (24-60)</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="TB/U/P-tab" data-bs-toggle="tab" href="#TB/U/P"
                                                    role="tab" aria-controls="TB/U/P" aria-selected="false"
                                                    tabindex="-1">Perempuan (24-60)</a>
                                            </li>
                                        </ul>

                                        {{-- ISI TAB LAKI DAN PEREMPUAN --}}
                                        <div class="tab-content" id="myTabContent">
                                            {{-- Laki-laki 0-24 Bulan --}}
                                            <div class="tab-pane active " id="PB/U/L" role="tabpanel"
                                                aria-labelledby="PB/U/L-tab">
                                                <p class="my-2 text-center">Standar Panjang Badan menurut Umur (PB/U)
                                                    Umur 0-24 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Panjang
                                                                    Badan (cm)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['pb_u_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan 0-24 Bulan --}}
                                            <div class="tab-pane " id="PB/U/P" role="tabpanel"
                                                aria-labelledby="PB/U/P-tab">
                                                <p class="my-2 text-center">Standar Panjang Badan menurut Umur (PB/U)
                                                    Umur 0-24 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Panjang
                                                                    Badan (cm)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['pb_u_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Laki-laki 24-60 Bulan --}}
                                            <div class="tab-pane  " id="TB/U/L" role="tabpanel"
                                                aria-labelledby="TB/U/L-tab">
                                                <p class="my-2 text-center">Standar Tinggi Badan menurut Umur (TB/U)
                                                    Umur 24-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Tinggi
                                                                    Badan (cm)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['tb_u_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan 24-60 Bulan --}}
                                            <div class="tab-pane " id="TB/U/P" role="tabpanel"
                                                aria-labelledby="TB/U/P-tab">
                                                <p class="my-2 text-center">Standar Tinggi Badan menurut Umur (TB/U)
                                                    Umur 24-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Tinggi
                                                                    Badan (cm)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['tb_u_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BB/TB --}}
                                    <div class="tab-pane fade" id="v-pills-BB/TB" role="tabpanel"
                                        aria-labelledby="v-pills-BB/TB-tab">

                                        {{-- TAB LAKI DAN PEREMPUAN --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="BB/PB/L-tab" data-bs-toggle="tab"
                                                    href="#BB/PB/L" role="tab" aria-controls="BB/PB/L"
                                                    aria-selected="true">Laki-laki (0-24)</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="BB/PB/P-tab" data-bs-toggle="tab"
                                                    href="#BB/PB/P" role="tab" aria-controls="BB/PB/P"
                                                    aria-selected="false" tabindex="-1">Perempuan (0-24)</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="BB/TB/L-tab" data-bs-toggle="tab"
                                                    href="#BB/TB/L" role="tab" aria-controls="BB/TB/L"
                                                    aria-selected="false">Laki-laki
                                                    (24-60)</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="BB/TB/P-tab" data-bs-toggle="tab"
                                                    href="#BB/TB/P" role="tab" aria-controls="BB/TB/P"
                                                    aria-selected="false" tabindex="-1">Perempuan (24-60)</a>
                                            </li>
                                        </ul>

                                        {{-- ISI TAB LAKI DAN PEREMPUAN --}}
                                        <div class="tab-content" id="myTabContent">
                                            {{-- Laki-laki 0-24 Bulan --}}
                                            <div class="tab-pane active" id="BB/PB/L" role="tabpanel"
                                                aria-labelledby="BB/PB/L-tab">
                                                <p class="my-2 text-center">Standar Berat Badan menurut Panjang Badan
                                                    (BB/PB) Umur 0-24 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Panjang
                                                                    Badan (cm)</th>
                                                                <th colspan="7">Berat
                                                                    Badan (Kg)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['bb_pb_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ rtrim($item->umur_atau_tinggi, '.0') }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan 0-24 Bulan --}}
                                            <div class="tab-pane " id="BB/PB/P" role="tabpanel"
                                                aria-labelledby="BB/PB/P-tab">
                                                <p class="my-2 text-center">Standar Berat Badan menurut Panjang Badan
                                                    (BB/PB) Umur 0-24 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Panjang
                                                                    Badan (cm)</th>
                                                                <th colspan="7">Berat
                                                                    Badan (Kg)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['bb_pb_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ rtrim($item->umur_atau_tinggi, '.0') }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Laki-laki 24-60 Bulan --}}
                                            <div class="tab-pane " id="BB/TB/L" role="tabpanel"
                                                aria-labelledby="BB/TB/L-tab">
                                                <p class="my-2 text-center">Standar Berat Badan menurut Tinggi Badan
                                                    (BB/TB) Umur 24-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Tinggi
                                                                    Badan (cm)</th>
                                                                <th colspan="7">Berat
                                                                    Badan (Kg)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['bb_tb_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ rtrim($item->umur_atau_tinggi, '.0') }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan 24-60 Bulan --}}
                                            <div class="tab-pane " id="BB/TB/P" role="tabpanel"
                                                aria-labelledby="BB/TB/P-tab">
                                                <p class="my-2 text-center">Standar Berat Badan menurut Tinggi Badan
                                                    (BB/TB) Umur 24-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Tinggi
                                                                    Badan (cm)</th>
                                                                <th colspan="7">Berat
                                                                    Badan (Kg)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['bb_tb_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ rtrim($item->umur_atau_tinggi, '.0') }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- IMT/U --}}
                                    <div class="tab-pane fade" id="v-pills-IMT/U" role="tabpanel"
                                        aria-labelledby="v-pills-IMT/U-tab">

                                        {{-- TAB LAKI DAN PEREMPUAN --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="IMT/U/P/L-tab" data-bs-toggle="tab"
                                                    href="#IMT/U/P/L" role="tab" aria-controls="IMT/U/P/L"
                                                    aria-selected="true">Laki-laki (0-24)</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="IMT/U/P/P-tab" data-bs-toggle="tab"
                                                    href="#IMT/U/P/P" role="tab" aria-controls="IMT/U/P/P"
                                                    aria-selected="false" tabindex="-1">Perempuan (0-24)</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="IMT/U/T/L-tab" data-bs-toggle="tab"
                                                    href="#IMT/U/T/L" role="tab" aria-controls="IMT/U/T/L"
                                                    aria-selected="false">Laki-laki
                                                    (24-60)</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="IMT/U/T/P-tab" data-bs-toggle="tab"
                                                    href="#IMT/U/T/P" role="tab" aria-controls="IMT/U/T/P"
                                                    aria-selected="false" tabindex="-1">Perempuan (24-60)</a>
                                            </li>
                                        </ul>

                                        {{-- ISI TAB LAKI DAN PEREMPUAN --}}
                                        <div class="tab-content" id="myTabContent">
                                            {{-- Laki-laki 0-24 Bulan --}}
                                            <div class="tab-pane active " id="IMT/U/P/L" role="tabpanel"
                                                aria-labelledby="IMT/U/P/L-tab">
                                                <p class="my-2 text-center">Standar Indeks Massa Tubuh menurut Umur (IMT/U)
                                                    Umur 0-24 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Indeks Massa Tubuh (IMT)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['imt_u_p_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan 0-24 Bulan --}}
                                            <div class="tab-pane " id="IMT/U/P/P" role="tabpanel"
                                                aria-labelledby="IMT/U/P/P-tab">
                                                <p class="my-2 text-center">Standar Indeks Massa Tubuh menurut Umur (IMT/U)
                                                    Umur 0-24 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Indeks Massa Tubuh (IMT)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['imt_u_p_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Laki-laki 24-60 Bulan --}}
                                            <div class="tab-pane  " id="IMT/U/T/L" role="tabpanel"
                                                aria-labelledby="IMT/U/T/L-tab">
                                                <p class="my-2 text-center">Standar Indeks Massa Tubuh menurut Umur (IMT/U)
                                                    Umur 24-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Indeks Massa Tubuh (IMT)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['imt_u_t_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan 24-60 Bulan --}}
                                            <div class="tab-pane " id="IMT/U/T/P" role="tabpanel"
                                                aria-labelledby="IMT/U/T/P-tab">
                                                <p class="my-2 text-center">Standar Indeks Massa Tubuh menurut Umur (IMT/U)
                                                    Umur 24-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Indeks Massa Tubuh (IMT)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['imt_u_t_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- LK/U --}}
                                    <div class="tab-pane fade" id="v-pills-LK/U" role="tabpanel"
                                        aria-labelledby="v-pills-LK/U-tab">

                                        {{-- TAB LAKI DAN PEREMPUAN --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="LK/U/L-tab" data-bs-toggle="tab"
                                                    href="#LK/U/L" role="tab" aria-controls="LK/U/L"
                                                    aria-selected="true">Laki-laki</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="LK/U/P-tab" data-bs-toggle="tab" href="#LK/U/P"
                                                    role="tab" aria-controls="LK/U/P" aria-selected="false"
                                                    tabindex="-1">Perempuan</a>
                                            </li>
                                        </ul>

                                        {{-- ISI TAB LAKI DAN PEREMPUAN --}}
                                        <div class="tab-content" id="myTabContent">
                                            {{-- Laki-laki --}}
                                            <div class="tab-pane active " id="LK/U/L" role="tabpanel"
                                                aria-labelledby="LK/U/L-tab">
                                                <p class="my-2 text-center">Standar Lingkar Kepala menurut Umur (LK/U)
                                                    Umur 0-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Lingkar Kepala (cm)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['lk_u_l'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Perempuan --}}
                                            <div class="tab-pane " id="LK/U/P" role="tabpanel"
                                                aria-labelledby="LK/U/P-tab">
                                                <p class="my-2 text-center">Standar Lingkar Kepala menurut Umur (LK/U)
                                                    Umur 0-60 Bulan</p>

                                                {{-- TABEL --}}
                                                <div class="table-responsive datatable-minimal">
                                                    <table class="table table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Umur
                                                                    (Bulan)
                                                                </th>
                                                                <th colspan="7">Lingkar Kepala (cm)</th>
                                                            </tr>
                                                            <tr>
                                                                <th>-3 SD</th>
                                                                <th>-2 SD</th>
                                                                <th>-1 SD</th>
                                                                <th>Median</th>
                                                                <th>1 SD</th>
                                                                <th>2 SD</th>
                                                                <th>3 SD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <style>
                                                                td {
                                                                    color: rgb(61, 61, 61);
                                                                }
                                                            </style>

                                                            @foreach ($data['lk_u_p'] as $item)
                                                                <tr>
                                                                    <td style="color:rgb(61, 61, 61);">
                                                                        {{ (int) $item->umur_atau_tinggi }}</td>

                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2neg }}</td>
                                                                    <td
                                                                        style="background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1neg }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(117, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->median }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 255, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd1 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 128, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd2 }}</td>
                                                                    <td
                                                                        style=" background-color: rgba(255, 0, 0, 0.3); color:rgb(61, 61, 61);">
                                                                        {{ $item->sd3 }}</td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>




    </div>
@endsection

@section('jsLibraries')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>



    {{-- JS Tooltip --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);
    </script>

    {{-- Swal Alert --}}

    <script>
        $(document).ready(function() {
            // SweetAlert untuk konfirmasi penghapusan
            $(".swal-delete").click(function(event) {
                event.preventDefault();

                let form = $(this).closest("form");

                Swal.fire({
                    title: "Hapus Data Balita?",
                    text: "Setelah dihapus, Anda tidak dapat memulihkan data ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#9c9c9c",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        form.submit(); // Submit form setelah konfirmasi
                    }
                });
            });

            // SweetAlert untuk notifikasi sukses atau error dari session
            @if (session()->has('success'))
                Swal.fire('Success', '{{ session('success') }}', 'success');
            @elseif (session()->has('error'))
                Swal.fire('Error', '{{ session('error') }}', 'error');
            @endif


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
@endsection
