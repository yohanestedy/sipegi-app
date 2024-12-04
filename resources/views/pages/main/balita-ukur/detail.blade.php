@extends('layout.main', ['title' => 'Data Pengukuran Balita'])


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

        .bg-light-warning1 {
            background-color: hsl(33, 100%, 92%) !important;
            color: #3f1f00 !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="#">Balita</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Data Pengukuran Balita
            </li>
        </ol>
    </nav>
@endsection
@section('mainContent')
    <div class="page-heading medium-text">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Pengukuran Balita</h3>
                    <p class="text-subtitle text-muted">Halaman data pengukuran balita.</p>
                </div>

            </div>
        </div>
        <section class="section">


            <div class="card">

                {{-- BIODATA --}}
                <div class="card-body pb-0 medium-text">

                    <div class="row">
                        <div class="pe-0 col-3 col-md-2 d-flex justify-content-between">
                            <span>NIK</span>
                            <span>:</span>
                        </div>
                        <div class="col-8 col-md-8">
                            <p class="mb-1">{{ $balita->nik == null ? '-' : $balita->nik }}</p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="pe-0 col-3 col-md-2 d-flex justify-content-between">
                            <span>Nama</span>
                            <span>:</span>
                        </div>
                        <div class="col-8 col-md-8">
                            <p class="mb-1">{{ $balita->name }}</p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="pe-0 col-3 col-md-2 d-flex justify-content-between">
                            <span>Tgl Lahir</span>
                            <span>:</span>
                        </div>
                        <div class="col-8 col-md-8">
                            <p class="mb-1">{{ $balita->tgl_lahir_display }}</p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="pe-0 col-3 col-md-2 d-flex justify-content-between">
                            <span>P/L</span>
                            <span>:</span>
                        </div>
                        <div class="col-8 col-md-8">
                            <p class="mb-1">{{ $balita->gender_display }}</p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="pe-0 col-3 col-md-2 d-flex justify-content-between">
                            <span>Umur</span>
                            <span>:</span>
                        </div>
                        <div class="col-8 col-md-8">
                            <p class="mb-1">{{ $balita->umur_display }}</p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="pe-0 col-3 col-md-2 d-flex justify-content-between">
                            <span>Posyandu</span>
                            <span>:</span>
                        </div>
                        <div class="col-8 col-md-8">
                            <p class="mb-1">{{ $balita->posyandu->name }}</p>
                        </div>

                    </div>





                </div>

                <div class="pb-1 card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Daftar Hasil Pengukuran
                    </h5>

                    @if ($balita->umur_hari <= 1856)
                        <a href="{{ route('balitaukur.add', ['id' => $balita->id]) }}" class="btn btn-primary rounded-pill">
                            <i class="fa-solid fa-plus"></i> Tambah Pengukuran
                        </a>
                    @endif



                </div>


                <div class="card-body">


                    <div class="mb-2">
                        <p class="d-block d-xl-none"
                            style="font-size: 0.85rem; color: #9d9e9f; font-weight: 500; margin-top: 8px; font-style: italic; text-align: left;">
                            *Geser ke samping untuk melihat data
                        </p>
                    </div>
                    <div class="table-responsive datatable-minimal">

                        <table class="table table-hover table-bordered medium-text text-center" id="tableBalitaUkur">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">Tindakan</th>
                                    <th rowspan="2" style="text-align: center;">Tgl Ukur</th>
                                    <th rowspan="2" style="text-align: center;">Umur Ukur</th>
                                    <th rowspan="2" style="text-align: center;">BB (kg)</th>
                                    <th rowspan="2" style="text-align: center;">TB (cm)</th>
                                    <th rowspan="2" style="text-align: center;">Cara Ukur</th>
                                    <th rowspan="2" style="text-align: center;">BB N/T/0</th>
                                    <th colspan="2" style="text-align: center;">BB / Umur</th>
                                    <th colspan="2" style="text-align: center;">TB / Umur</th>
                                    <th colspan="2" style="text-align: center;">BB / TB</th>
                                    <th colspan="2" style="text-align: center;">IMT / Umur</th>
                                    <th colspan="2" style="text-align: center;">LK / Umur</th>

                                </tr>


                                <tr>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">ZScore</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">ZScore</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">ZScore</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">ZScore</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">ZScore</th>
                                </tr>


                            </thead>
                            <tbody>

                                @foreach ($balita->balitaUkur as $balitaUkur)
                                    <tr>

                                        <td style="text-align: center">
                                            {{-- <a href="{{ route('balitaukur.add', ['id' => $balita->id]) }}"
                                                class="btn icon btn-primary " data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Pengukuran"
                                                style="border-radius: 8px; padding: .2rem .4rem;">
                                                <i class="fa-solid fa-calculator"></i></a> --}}
                                            <button type="button" class="btn icon btn-info modal-btn"
                                                data-balita='@json($balita)'
                                                data-ukur='@json($balitaUkur)' data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Lihat Detail"
                                                style="border-radius: 8px; padding: .2rem .4rem; color:white;">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>


                                            <a href="{{ route('balitaukur.edit', ['id' => $balitaUkur->id]) }}"
                                                class="btn icon btn-success " data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Ubah Pengukuran"
                                                style="border-radius: 8px; padding: .2rem .4rem;">
                                                <i class="fa-regular fa-pen-to-square"></i></button>

                                                {{-- <form action="{{ route('balita.delete', ['id' => $balita->id]) }}"
                                                method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn icon btn-sm btn-danger mt-1 mb-1 me-1 swal-delete"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="Hapus" style="border-radius: 8px;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form> --}}


                                        </td>
                                        <td data-order="{{ $balitaUkur->tgl_ukur }}" style="text-align: center">
                                            {{ $balitaUkur->tgl_ukur_display }}</td>
                                        <td style="text-align: center">
                                            {{ $balitaUkur->umur_ukur }}</td>
                                        <td style="text-align: center">{{ $balitaUkur->bb }}</td>
                                        <td style="text-align: center">{{ $balitaUkur->tb }}</td>
                                        <td style="text-align: center">{{ $balitaUkur->cara_ukur }}</td>
                                        <td style="text-align: center">{{ $balitaUkur->status_bb_naik }}</td>

                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_bb_u) }}">
                                                {{ $balitaUkur->status_bb_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">{{ $balitaUkur->zscore_bb_u }}</td>

                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_tb_u) }}">
                                                {{ $balitaUkur->status_tb_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">{{ $balitaUkur->zscore_tb_u }}</td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_bb_tb) }}">
                                                {{ $balitaUkur->status_bb_tb }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">{{ $balitaUkur->zscore_bb_tb }}</td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_imt_u) }}">
                                                {{ $balitaUkur->status_imt_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">{{ $balitaUkur->zscore_imt_u }}</td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_lk_u) }}">
                                                {{ $balitaUkur->status_lk_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">{{ $balitaUkur->zscore_lk_u }}</td>




                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>





        </section>




    </div>
    {{-- MODAL HASIL PENGUKURAN --}}
    <div class="modal fade" id="zscoreModal" tabindex="-1" aria-labelledby="zscoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="zscoreModalLabel">Hasil Pengukuran Balita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-7 col-md-6">
                                    <style>
                                        #balita_name {
                                            word-wrap: break-word;
                                            /* Potong kata jika terlalu panjang */
                                            word-break: break-word;
                                            /* Izinkan pemenggalan kata */
                                            white-space: normal;
                                            /* Izinkan teks berada di lebih dari satu baris */
                                        }
                                    </style>
                                    <label class="medium-text">Nama Balita :</label><br>
                                    <p class="text-start badge bg-light-secondary form-control-static fw-normal"
                                        id="balita_name">
                                    </p><br>
                                    <label class="medium-text">Tanggal Pengukuran :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="tgl_ukur1">
                                    </p><br>
                                    <label class="medium-text">Umur Pengukuran :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="umur_ukur">
                                    </p>
                                    <br>
                                    <label class="medium-text">Cara Pengukuran :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="cara_ukur">
                                    </p><br>

                                </div>
                                <div class="col-5 col-md-6">
                                    <label class="medium-text">Berat Badan :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="bb">
                                    </p><br>
                                    <label class="medium-text">Tinggi Badan :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="tb">
                                    </p><br>
                                    <label class="medium-text">Lingkar Kepala :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="lk">
                                    </p><br>
                                    <label class="medium-text">Status BB :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="status_bb_naik">
                                    </p><br>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-12">
                            <hr>
                            {{-- ROW KOLOM HEADER --}}
                            <div class="row mb-2">
                                <div class="col-9 col-md-9">
                                    <label class="medium-text"><strong>PENILAIAN STATUS GIZI</strong></label>
                                </div>
                                <div class="col-3 col-md-3">
                                    <label class="medium-text"><strong>Z-SCORE</strong></label>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2 ">
                                <div class="col-2 col-md-3">
                                    <label>BB/U</label>
                                </div>
                                <div class="col-7 col-md-6">
                                    <span id="status_bb_u" class="badge"></span>
                                </div>
                                <div class="col-2 col-md-2 text-end">
                                    <span id="zscore_bb_u"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-2 col-md-3">
                                    <label>TB/U</label>
                                </div>
                                <div class="col-7 col-md-6">
                                    <span id="status_tb_u" class="badge"></span>
                                </div>
                                <div class="col-2 col-md-2 text-end">
                                    <span id="zscore_tb_u"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-2 col-md-3">
                                    <label>BB/TB</label>
                                </div>
                                <div class="col-7 col-md-6">
                                    <span id="status_bb_tb" class="badge"></span>
                                </div>
                                <div class="col-2 col-md-2 text-end">
                                    <span id="zscore_bb_tb"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-2 col-md-3">
                                    <label>IMT/U</label>
                                </div>
                                <div class="col-7 col-md-6">
                                    <span id="status_imt_u" class="badge"></span>
                                </div>
                                <div class="col-2 col-md-2 text-end">
                                    <span id="zscore_imt_u"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-2 col-md-3">
                                    <label>LK/U</label>
                                </div>
                                <div class="col-7 col-md-6">
                                    <span id="status_lk_u" class="badge"></span>
                                </div>
                                <div class="col-2 col-md-2 text-end">
                                    <span id="zscore_lk_u"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                </div> --}}
            </div>
        </div>
    </div>

    {{-- Fungsi Badge Status Gizi --}}
    @php
        function getStatusClass($status)
        {
            switch ($status) {
                case 'Berat badan normal':
                case 'Normal':
                case 'Gizi baik':
                    return 'bg-light-success';

                case 'Resiko berat badan lebih':
                case 'Beresiko gizi lebih':
                    return 'bg-light-warning';

                case 'Berat badan kurang':
                case 'Pendek':
                case 'Gizi kurang':
                case 'Gizi lebih':
                    return 'bg-light-warning1';

                case 'Berat badan sangat kurang':
                case 'Sangat pendek':
                case 'Tinggi':
                case 'Gizi buruk':
                case 'Obesitas':
                case 'Mikrosefali':
                case 'Makrosefali':
                    return 'bg-light-danger';
                default:
                    return 'bg-secondary';
            }
        }
    @endphp
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

    <script>
        $(document).ready(function() {
            // Open modal and populate input
            $('.modal-btn').click(function() {
                const balita = $(this).data('balita'); // Langsung parse objek data dari atribut
                const ukur = $(this).data('ukur');

                // Isi modal dengan data dari objek balita dan ukur
                $('#balita_name').text(balita.name);
                $('#tgl_ukur1').text(ukur.tgl_ukur_display);
                $('#umur_ukur').text(ukur.umur_ukur);
                $('#cara_ukur').text(ukur.cara_ukur);
                $('#bb').text(ukur.bb + " kg");
                $('#tb').text(ukur.tb + " cm");
                $('#lk').text(ukur.lk ? ukur.lk + " cm" : '-');
                $('#status_bb_naik').text(ukur.status_bb_naik);

                // Perbaharui status gizi dan z-score
                $('#status_bb_u').text(ukur.status_bb_u).attr('class', 'badge ' + getStatusClass(ukur
                    .status_bb_u));
                $('#zscore_bb_u').text(ukur.zscore_bb_u);
                $('#status_tb_u').text(ukur.status_tb_u).attr('class', 'badge ' + getStatusClass(ukur
                    .status_tb_u));
                $('#zscore_tb_u').text(ukur.zscore_tb_u);
                $('#status_bb_tb').text(ukur.status_bb_tb).attr('class', 'badge ' + getStatusClass(ukur
                    .status_bb_tb));
                $('#zscore_bb_tb').text(ukur.zscore_bb_tb);
                $('#status_imt_u').text(ukur.status_imt_u).attr('class', 'badge ' + getStatusClass(ukur
                    .status_imt_u));
                $('#zscore_imt_u').text(ukur.zscore_imt_u);
                $('#status_lk_u').text(ukur.status_lk_u ? ukur.status_lk_u : '-').attr('class', 'badge ' +
                    getStatusClass(ukur.status_lk_u ? ukur.status_lk_u : ''));
                $('#zscore_lk_u').text(ukur.zscore_lk_u ? ukur.zscore_lk_u : '-');

                // Tampilkan modal
                $('#zscoreModal').modal('show');
            });
        });


        // Fungsi untuk mengembalikan class badge berdasarkan status
        function getStatusClass(status) {
            switch (status) {
                case 'Berat badan normal':
                case 'Normal':
                case 'Gizi baik':
                    return 'bg-light-success';

                case 'Resiko berat badan lebih':
                case 'Beresiko gizi lebih':
                    return 'bg-light-warning';

                case 'Berat badan kurang':
                case 'Pendek':
                case 'Gizi kurang':
                case 'Gizi lebih':
                    return 'bg-light-warning1';

                case 'Berat badan sangat kurang':
                case 'Sangat pendek':
                case 'Tinggi':
                case 'Gizi buruk':
                case 'Obesitas':
                case 'Mikrosefali':
                case 'Makrosefali':
                    return 'bg-light-danger';
                default:
                    return 'bg-secondary';
            }
        }
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
