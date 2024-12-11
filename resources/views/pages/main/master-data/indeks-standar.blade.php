@extends('layout.main', ['title' => 'Indeks Standar Antropometri Anak'])

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
                Indeks Standar Antropometri Anak
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-12 order-md-1 order-last">
                    <h3>Indeks Standar Antropometri Anak</h3>
                    <p class="text-subtitle text-muted">Standar Antropometri Anak didasarkan pada parameter berat badan,
                        panjang/tinggi badan, dan lingkar kepala yang terdiri atas 5 (lima) indeks, meliputi:</p>
                </div>

            </div>
        </div>
        <section class="section">


            <div class="card">
                {{-- <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Daftar Posyandu Desa Selorejo
                    </h5>

                </div> --}}
                <div class="card-body">

                    <div class="mb-2">
                        <p class="d-block d-xl-none"
                            style="font-size: 0.85rem; color: #9d9e9f; font-weight: 500; margin-top: 8px; font-style: italic; text-align: left;">
                            *Geser ke samping untuk melihat data
                        </p>
                    </div>
                    <div class="table-responsive datatable-minimal">

                        <table class="table table-hover table-bordered medium-text">
                            <thead>
                                <tr style=" background-color: rgba(206, 206, 206, 0.3); color:rgb(61, 61, 61);">
                                    <th style="text-align: center; width: 30%">Indeks Standar Pertumbuhan</th>
                                    <th style="text-align: center; white-space: nowrap;">Kategori Status Gizi</th>
                                    <th style="text-align: center; white-space: nowrap;">Ambang Batas (Z-Score)</th>

                                </tr>
                            </thead>
                            <tbody style="text-align: center;">

                                {{-- BB/U --}}
                                <div>
                                    <tr style="text-align: center;">
                                        <td rowspan="5">Berat Badan menurut Umur <strong>(BB/U)</strong></td>
                                    </tr>

                                    <tr>
                                        <td>Berat badan sangat kurang ( <i>severely underweight</i> )</td>
                                        <td>
                                            < -3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Berat badan kurang ( <i>underweight</i> )</td>
                                        <td> -3 SD s.d. -2 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Berat badan normal</td>
                                        <td>-2 SD s.d. 1 SD </td>

                                    </tr>
                                    <tr>
                                        <td>Resiko Berat badan lebih</td>
                                        <td> > 1 SD </td>
                                    </tr>
                                </div>

                                <tr style=" background-color: rgba(206, 206, 206, 0.3); color:rgb(61, 61, 61);">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                {{-- TB/U --}}
                                <div>
                                    <tr style="text-align: center;">
                                        <td rowspan="5">Panjang Badan atau Tinggi Badan menurut Umur <strong>(PB/U atau
                                                TB/U)</strong></td>
                                    </tr>

                                    <tr>
                                        <td>Sangat Pendek ( <i>severely stunted</i> )</td>
                                        <td>
                                            < -3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Pendek ( <i>stunted</i> )</td>
                                        <td> -3 SD s.d. -2 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Normal</td>
                                        <td> -2 SD s.d. 3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Tinggi</td>
                                        <td> > 3 SD </td>
                                    </tr>
                                </div>

                                <tr style=" background-color: rgba(206, 206, 206, 0.3); color:rgb(61, 61, 61);">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                {{-- BB/TB --}}
                                <div>
                                    <tr style="text-align: center;">
                                        <td rowspan="7">Berat Badan menurut Panjang Badan atau Tinggi Badan
                                            <strong>(BB/PB atau BB/TB)</strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Gizi Buruk ( <i>severely wasted</i> )</td>
                                        <td>
                                            < -3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Gizi Kurang ( <i>wasted</i> )</td>
                                        <td> -3 SD s.d. -2 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Gizi Baik ( <i>normal</i> )</td>
                                        <td> -2 SD s.d. 1 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Beresiko Gizi Lebih</td>
                                        <td> 1 SD s.d. 2 SD </td>

                                    </tr>
                                    <tr>
                                        <td>Gizi lebih ( <i>overweight</i> )</td>
                                        <td> 2 SD s.d. 3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Obesitas ( <i>obese</i> )</td>
                                        <td> > 3 SD </td>
                                    </tr>
                                </div>

                                <tr style=" background-color: rgba(206, 206, 206, 0.3); color:rgb(61, 61, 61);">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                {{-- IMT/U --}}
                                <div>
                                    <tr style="text-align: center;">
                                        <td rowspan="7">Indeks Massa Tubuh menurut Umur <strong>(IMT/U)</strong></td>
                                    </tr>

                                    <tr>
                                        <td>Gizi Buruk ( <i>severely wasted</i> )</td>
                                        <td>
                                            < -3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Gizi Kurang ( <i>wasted</i> )</td>
                                        <td> -3 SD s.d. -2 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Gizi Baik ( <i>normal</i> )</td>
                                        <td> -2 SD s.d. 1 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Beresiko Gizi Lebih</td>
                                        <td> 1 SD s.d. 2 SD </td>

                                    </tr>
                                    <tr>
                                        <td>Gizi lebih ( <i>overweight</i> )</td>
                                        <td> 2 SD s.d. 3 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Obesitas ( <i>obese</i> )</td>
                                        <td> > 3 SD </td>
                                    </tr>
                                </div>

                                <tr style=" background-color: rgba(206, 206, 206, 0.3); color:rgb(61, 61, 61);">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                {{-- IMT/U --}}
                                <div>
                                    <tr style="text-align: center;">
                                        <td rowspan="4">Lingkar Kepala menurut Umur <strong>(LK/U)</strong></td>
                                    </tr>

                                    <tr>
                                        <td>Mikrosefali</td>
                                        <td>
                                            < -2 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Normal</td>
                                        <td> -2 SD s.d. 2 SD </td>
                                    </tr>
                                    <tr>
                                        <td>Makrosefali</td>
                                        <td> > 2 SD </td>
                                    </tr>

                                </div>



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
