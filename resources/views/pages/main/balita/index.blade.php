@extends('layout.main', ['title' => 'Balita'])

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
                <a href="{{ route('balita.index') }}">Balita</a>
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
                    <h3>Balita</h3>
                    <p class="text-subtitle text-muted">Halaman daftar nama-nama balita aktif.</p>
                </div>

            </div>
        </div>
        <section class="section">


            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Daftar Balita
                    </h5>
                    <a href="{{ route('balita.add') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </a>
                </div>
                <div class="card-body">

                    <div class="mb-2">
                        <p class="d-block d-xl-none"
                            style="font-size: 0.75rem; color: #9d9e9f; font-style:italic; font-weight: 500; margin-top: 8px;  text-align: left;">
                            *Klik tombol <i class="fa-solid fa-magnifying-glass"></i> atau geser ke <i
                                class="fa-solid fa-arrow-right-long"></i> untuk melihat data
                        </p>
                    </div>
                    <div class="table-responsive datatable-minimal">
                        <div class="row mb-3 align-items-center">
                            @if (in_array(Auth::user()->role, ['super_admin', 'admin', 'kader_poskesdes']))
                                <div class="col-6 col-md-4">
                                    <select id="filterPosyandu" class="form-select form-select-sm">
                                        <option value="">Semua Posyandu</option>
                                        @foreach ($posyandus as $posyandu)
                                            <option value="{{ $posyandu->name }}">{{ $posyandu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="col-6 col-md-8">
                                <div class="medium-text">Jumlah Balita: <span id="jumlahDataBalita"></span></div>
                            </div>
                        </div>


                        <table class="table table-hover table-bordered medium-text" id="tableBalita">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Tombol</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">NIK</th>
                                    <th style="text-align: center;">Jenis Kelamin</th>
                                    <th style="text-align: center;">Tanggal Lahir</th>
                                    <th style="text-align: center;">Umur Saat Ini</th>
                                    <th style="text-align: center;">Nama Ibu</th>
                                    <th style="text-align: center;">Posyandu</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($balita as $balita)
                                    <tr>

                                        <td style="text-align: center">

                                            <button type="button" class="btn icon btn-info modal-btn btn-sm"
                                                data-balita='@json($balita)' data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Lihat Detail"
                                                style="border-radius: 8px; padding: .2rem .35rem; color:white;">
                                                <i class="fa-solid fa-magnifying-glass"></i>

                                            </button>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm show"
                                                        style="border-radius: 8px; padding: .2rem .35rem;" type="button"
                                                        id="dropdownMenuButtonIcon" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-dark"
                                                        aria-labelledby="dropdownMenuButtonIcon"
                                                        style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 40px, 0px);"
                                                        data-popper-placement="bottom-start">
                                                        <a class="dropdown-item ps-3"
                                                            href="{{ route('balitaukur.detail', ['id' => $balita->id]) }}"><i
                                                                class="fa-regular fa-list-check me-1"></i>
                                                            Riwayat Pengukuran</a>
                                                        <a class="dropdown-item ps-3"
                                                            href="{{ route('balita.edit', ['id' => $balita->id]) }}"><i
                                                                class="fa-regular fa-pen-to-square me-1"></i>
                                                            Ubah Biodata</a>

                                                    </div>

                                                </div>
                                            </div>
                                            {{-- <a href="{{ route('balitaukur.detail', ['id' => $balita->id]) }}"
                                                class="btn icon btn-primary btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Riwayat Pengukuran"
                                                style="border-radius: 8px; padding: .2rem .35rem;">
                                                <i class="fa-regular fa-list-check"></i></a>
                                            <a href="{{ route('balita.edit', ['id' => $balita->id]) }}"
                                                class="btn icon btn-success btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Edit"
                                                style="border-radius: 8px; padding: .2rem .35rem;">
                                                <i class="fa-regular fa-pen-to-square"></i></a> --}}

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
                                        <td>{{ $balita->name }}</td>
                                        <td style="text-align: center">{{ $balita->nik == null ? '-' : $balita->nik }}</td>
                                        <td style="text-align: center">
                                            <div style="font-weight: 600; {{ $balita->gender_display == 'Perempuan' ? 'background-color: #fcd8ff; color:#855f82' : 'background-color: #d2eeff; color: #526483' }} "
                                                class="badge">
                                                {{ $balita->gender_display }}</div>
                                        </td>
                                        <td>{{ $balita->tgl_lahir_display }}</td>
                                        <td data-sort="{{ $balita->umur_hari }}">{{ $balita->umur_display }}</td>
                                        <td>{{ $balita->orangtua->name_ibu }}</td>
                                        <td data-sort="{{ $balita->posyandu_id }}" style="text-align: center">
                                            {{ $balita->posyandu->name }}</td>


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
    <div class="modal fade" id="balitaModal" tabindex="-1" aria-labelledby="balitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="balitaModalLabel">Biodata Balita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-7 col-md-6 pe-0">


                                    <label class="medium-text">Nama Balita :</label><br>
                                    <p class="text-start badge bg-light-secondary form-control-static fw-bold text-wrap"
                                        id="balita_name">
                                    </p><br>
                                    <label class="medium-text">NIK Balita :</label><br>
                                    <p class="text-start badge bg-light-secondary form-control-static fw-normal"
                                        id="nik_balita">
                                    </p><br>

                                    <label class="medium-text">Tanggal Lahir :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="tgl_lahir">
                                    </p><br>
                                    <label class="medium-text">Umur Saat Ini :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="umur">
                                    </p>
                                    <br>
                                    <label class="medium-text">Anak ke :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="family_order">
                                    </p><br>




                                </div>
                                <div class="col-5 col-md-6">
                                    <label class="medium-text">Jenis Kelamin :</label><br>
                                    <p class="text-start badge bg-light-secondary form-control-static fw-normal"
                                        id="gender">
                                    </p><br>
                                    <label class="medium-text">BB / TB Lahir :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="bbtb_lahir">
                                    </p><br>
                                    <label class="medium-text">BPJS Balita :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="bpjs">
                                    </p><br>
                                    <label class="medium-text">Posyandu :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="posyandu">
                                    </p><br>
                                    <label class="medium-text">Status :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="status">
                                    </p>
                                    <br>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-12 mt-3">


                            {{-- ROW KOLOM ORANGTUA --}}
                            <div class="row">
                                <div class="col-9 col-md-9">
                                    <label><strong>DATA ORANGTUA</strong></label>
                                </div>

                            </div>
                            <hr class="my-2">

                            <div class="row">
                                <div class="col-7 col-md-6 pe-0">
                                    <label class="medium-text">No KK :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="kk">
                                    </p><br>
                                    <label class="medium-text">Nama Ibu :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-bold text-wrap"
                                        id="name_ibu">
                                    </p><br>
                                    <label class="medium-text">NIK Ibu :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="nik_ibu">
                                    </p><br>
                                    <label class="medium-text">Nama Ayah :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-bold text-wrap"
                                        id="name_ayah">
                                    </p><br>
                                    <label class="medium-text">NIK Ayah :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="nik_ayah">
                                    </p><br>

                                </div>
                                <div class="col-5 col-md-6">



                                    <label class="medium-text">No. Telp / WA :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="telp">
                                    </p><br>
                                    <label class="medium-text">RT / RW :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="rtrw">
                                    </p><br>
                                    <label class="medium-text">Dusun :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="dusun">
                                    </p><br>
                                    <label class="medium-text">Alamat :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal text-wrap"
                                        id="alamat">
                                    </p><br>


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
@endsection

@section('jsLibraries')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>





    {{-- JS Tooltip --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);
    </script> --}}

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

    </script>

    {{-- Swal Alert Hapus --}}
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
            // Delegasikan event click pada tombol modal-btn
            $('#tableBalita').on('click', '.modal-btn', function() {
                // Langsung parse objek data dari atribut
                const balita = $(this).data('balita');

                // Isi modal dengan data dari objek balita dan ukur
                $('#balita_name').text(balita.name);
                $('#nik_balita').text(balita.nik ? balita.nik : '-');
                $('#gender').text(balita.gender_display);
                $('#tgl_lahir').text(balita.tgl_lahir_display);
                $('#umur').text(balita.umur_display);
                $('#bbtb_lahir').text(balita.bb_lahir + " kg" + " / " + balita.tb_lahir + " cm");
                $('#posyandu').text(balita.posyandu.name);
                $('#bpjs').text(balita.bpjs);
                $('#status').text(balita.status);
                $('#family_order').text(balita.family_order);

                $('#kk').text(balita.orangtua.no_kk);
                $('#name_ibu').text(balita.orangtua.name_ibu);
                $('#nik_ibu').text(balita.orangtua.nik_ibu ? balita.orangtua.nik_ibu : '-');
                $('#name_ayah').text(balita.orangtua.name_ayah);
                $('#nik_ayah').text(balita.orangtua.nik_ayah ? balita.orangtua.nik_ayah : '-');
                $('#telp').text(balita.orangtua.telp ? balita.orangtua.telp : '-');
                $('#alamat').text(balita.orangtua.alamat);
                $('#rtrw').text(balita.orangtua.rt.rt + " / " + balita.orangtua.dusun.rw);
                $('#dusun').text(balita.orangtua.dusun.name);



                // Tampilkan modal
                $('#balitaModal').modal('show');
            });
        });
    </script>
@endsection
