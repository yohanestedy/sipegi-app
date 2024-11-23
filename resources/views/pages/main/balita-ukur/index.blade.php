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
                            <p class="mb-1">{{ $balita->nik }}</p>
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
                    <a href="{{ route('balitaukur.add', ['id' => $balita->id]) }}" class="btn btn-primary rounded-pill">
                        <i class="fa-solid fa-plus"></i> Tambah Pengukuran
                    </a>


                </div>


                <div class="card-body">


                    <div class="mb-2">
                        <p class="d-block d-xl-none"
                            style="font-size: 0.85rem; color: #9d9e9f; font-weight: 500; margin-top: 8px; font-style: italic; text-align: left;">
                            *Geser ke samping untuk melihat data
                        </p>
                    </div>
                    <div class="table-responsive datatable-minimal">

                        <table class="table table-hover table-bordered" id="tableBalitaUkur">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Tindakan</th>
                                    <th style="text-align: center;">Tgl Ukur</th>
                                    <th style="text-align: center;">BB (kg)</th>
                                    <th style="text-align: center;">TB (cm)</th>
                                    <th style="text-align: center;">Cara Ukur</th>
                                    <th style="text-align: center;">BB/U</th>
                                    <th style="text-align: center;">TB/U</th>
                                    <th style="text-align: center;">BB/TB</th>
                                    <th style="text-align: center;">IMT/U</th>
                                    <th style="text-align: center;">LK/U</th>

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
                                            <a href="{{ route('balitaukur.edit', ['id' => $balitaUkur->id]) }}"
                                                class="btn icon btn-success " data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Ubah Pengukuran"
                                                style="border-radius: 8px; padding: .2rem .4rem;">
                                                <i class="fa-regular fa-pen-to-square"></i></a>

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
                                        <td style="text-align: center">{{ $balitaUkur->bb }}</td>
                                        <td style="text-align: center">{{ $balitaUkur->tb }}</td>
                                        <td style="text-align: center">{{ $balitaUkur->cara_ukur }}</td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_bb_u) }}">
                                                {{ $balitaUkur->status_bb_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_tb_u) }}">
                                                {{ $balitaUkur->status_tb_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_bb_tb) }}">
                                                {{ $balitaUkur->status_bb_tb }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_imt_u) }}">
                                                {{ $balitaUkur->status_imt_u }}
                                            </span>
                                        </td>
                                        <td style="text-align: center">
                                            <span class="badge {{ getStatusClass($balitaUkur->status_lk_u) }}">
                                                {{ $balitaUkur->status_lk_u }}
                                            </span>
                                        </td>




                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>



        </section>


    </div>

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
