@extends('layout.main', ['title' => 'Daftar Posyandu'])

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
                Daftar Posyandu
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Posyandu</h3>
                    <p class="text-subtitle text-muted">Halaman daftar posyandu.</p>
                </div>

            </div>
        </div>
        <section class="section">


            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Daftar Posyandu Desa Selorejo
                    </h5>
                    {{-- <a href="{{ route('balita.add') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </a> --}}
                </div>
                <div class="card-body">

                    <div class="mb-2">
                        <p class="d-block d-xl-none"
                            style="font-size: 0.8rem; color: #a3a3a3; font-weight: 500; margin-top: 8px; font-style: italic; text-align: left;">
                            *Geser ke <i class="fa-solid fa-arrow-right-long"></i> untuk melihat data
                        </p>
                    </div>
                    <div class="table-responsive datatable-minimal">

                        <table class="table table-hover table-bordered medium-text">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">RW</th>
                                    <th style="text-align: center;">Posyandu</th>
                                    <th style="text-align: center;">Dusun</th>
                                    <th style="text-align: center;">Petugas SiPeGi</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($posyandus as $posyandu)
                                    <tr style="text-align: center;">
                                        {{-- <td style="text-align: center">
                                            <a href="{{ route('balita.edit', ['id' => $balita->id]) }}"
                                                class="btn icon btn-sm btn-primary " data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Edit"
                                                style="border-radius: 8px;">
                                                <i class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('balita.delete', ['id' => $balita->id]) }}"
                                                method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn icon btn-sm btn-danger mt-1 mb-1 me-1 swal-delete"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="Hapus" style="border-radius: 8px;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>


                                        </td> --}}
                                        <td>{{ $posyandu->dusun->rw }}</td>
                                        <td>{{ $posyandu->name }}</td>
                                        <td>{{ $posyandu->dusun->name }}</td>
                                        <td>
                                            @foreach ($posyandu->user as $user)
                                                {{ $user->name }}
                                            @endforeach
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
@endsection

@section('jsLibraries')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>



    {{-- JS Tooltip --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Menonaktifkan tooltip saat modal muncul
            $('.modal').on('show.bs.modal', function() {
                tooltipList.forEach(function(tooltip) {
                    tooltip.hide();
                });
            });

            // Menonaktifkan tooltip saat modal ditutup
            $('.modal').on('hidden.bs.modal', function() {
                tooltipList.forEach(function(tooltip) {
                    tooltip.dispose();
                });
            });
        });
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
