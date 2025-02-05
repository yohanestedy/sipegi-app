@extends('layout.main', ['title' => 'Orangtua'])

@section('cssLibraries')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/table-datatable-jquery.css') }}">
    <style>
        /* Mengatur padding untuk semua <td> dalam tabel dengan ID 'tableUser' */
        table.dataTable td {
            padding: 8px 8px !important;
            white-space: nowrap !important;
            /* Ubah nilai sesuai kebutuhan */
        }
    </style>
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('orangtua.index') }}">Orangtua</a>
            </li>
            {{-- <li class="breadcrumb-item active" aria-current="page">
                Layout Default
            </li> --}}
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Orangtua</h3>
                    <p class="text-subtitle text-muted">Halaman daftar orangtua balita.</p>
                </div>
            </div>
        </div>
        <section class="section">


            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Daftar Orangtua
                    </h5>
                    <a href="{{ route('orangtua.add') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah
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
                                <div class="medium-text">Jumlah Orangtua: <span id="jumlahDataOrangtua"></span></div>
                            </div>
                        </div>

                        <table class="table table-hover table-bordered medium-text" id="tableOrtu">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Aksi</th>
                                    <th style="text-align: center;">Nama Ibu</th>
                                    <th style="text-align: center;">NIK Ibu</th>
                                    <th style="text-align: center;">RT</th>
                                    <th style="text-align: center;">RW</th>
                                    <th style="text-align: center;">Posyandu</th>
                                    <th style="text-align: center;">Telp</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orangtua as $orangtua)
                                    <tr>
                                        <td style="text-align: center">

                                            <button type="button" class="btn icon btn-info modal-btn btn-sm"
                                                data-orangtua='@json($orangtua)' data-bs-toggle="tooltip"
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
                                                            href="{{ route('orangtua.edit', ['id' => $orangtua->id]) }}"><i
                                                                class="fa-regular fa-pen-to-square me-1"></i>
                                                            Ubah Data Orangtua</a>

                                                    </div>

                                                </div>
                                            </div>

                                            {{-- <a href="{{ route('orangtua.edit', ['id' => $orangtua->id]) }}"
                                                class="btn icon btn-sm btn-primary mt-1 mb-1 me-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Ubah Data Ortu"
                                                style="border-radius: 8px; padding: .2rem .35rem;">
                                                <i class="fa-regular fa-pen-to-square"></i></a> --}}
                                            {{-- <form action="{{ route('orangtua.delete', ['id' => $orangtua->id]) }}"
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
                                        <td>{{ $orangtua->name_ibu }}</td>
                                        <td>{{ $orangtua->nik_ibu ?? 'Belum input NIK' }}</td>
                                        <td class="text-center">{{ $orangtua->rt->rt }}</td>
                                        <td class="text-center">{{ $orangtua->dusun->rw }}</td>
                                        <td class="text-center" data-sort="{{ $orangtua->dusun->posyandu->id }}">
                                            {{ $orangtua->dusun->posyandu->name }}</td>
                                        <td class="text-center">{{ $orangtua->telp ?? '-' }}</td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>



        </section>


    </div>

    {{-- MODAL DETAIL ORANGTUA --}}
    <div class="modal fade" id="ortuModal" tabindex="-1" aria-labelledby="ortuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="ortuModalLabel">Data Orangtua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">




                            <div class="row">
                                <div class="col-7 col-md-6 pe-0 ">
                                    <label class="medium-text">No KK :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="kk">
                                    </p><br>
                                    <label class="medium-text">Nama Ibu :</label><br>
                                    <p class="badge bg-light-secondary form-control-static text-wrap text-start"
                                        id="name_ibu">
                                    </p><br>
                                    <label class="medium-text">NIK Ibu :</label><br>
                                    <p class="badge bg-light-secondary form-control-static fw-normal" id="nik_ibu">
                                    </p><br>
                                    <label class="medium-text">Nama Ayah :</label><br>
                                    <p class="badge bg-light-secondary form-control-static text-wrap text-start"
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
                                    <p class="badge bg-light-secondary form-control-static fw-normal text-wrap text-start"
                                        id="alamat">
                                    </p><br>


                                </div>
                            </div>


                        </div>
                        <div class="col-md-12 mt-3">
                            {{-- ROW KOLOM ORANGTUA --}}
                            <div class="row">
                                <div class="col-9 col-md-9">
                                    <label><strong>Data Anak</strong></label>
                                </div>
                            </div>


                            <!-- Tabel untuk menampilkan data balita -->
                            <div class="table-responsive">
                                <table class="table table-bordered  medium-text">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Balita</th>
                                            <th>JK</th>
                                            <th class="text-center">Umur</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="balita_table_body">
                                        <!-- Data balita akan dimasukkan di sini -->
                                    </tbody>
                                </table>
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
                    title: "Hapus Data Orangtua?",
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
            $('#tableOrtu').on('click', '.modal-btn', function() {
                // Langsung parse objek data dari atribut
                const orangtua = $(this).data('orangtua');

                $('#kk').text(orangtua.no_kk);
                $('#name_ibu').text(orangtua.name_ibu);
                $('#nik_ibu').text(orangtua.nik_ibu ? orangtua.nik_ibu : '-');
                $('#name_ayah').text(orangtua.name_ayah);
                $('#nik_ayah').text(orangtua.nik_ayah ? orangtua.nik_ayah : '-');
                $('#telp').text(orangtua.telp ? orangtua.telp : '-');
                $('#alamat').text(orangtua.alamat);
                $('#rtrw').text(orangtua.rt.rt + " / " + orangtua.dusun.rw);
                $('#dusun').text(orangtua.dusun.name);

                console.log(orangtua.balita_nonaktif);


                // Kosongkan tabel balita sebelumnya
                $('#balita_table_body').empty();

                // Tambahkan data balita Nonaktif ke dalam tabel jika ada
                if (orangtua.balita_nonaktif && orangtua.balita_nonaktif.length > 0) {
                    orangtua.balita_nonaktif.forEach(function(balita) {
                        $('#balita_table_body').append(`
                            <tr>
                                <td class="text-center">
                                    <small>${balita.family_order}</small>
                                </td>
                                <td>
                                    <a href="/balita-nonaktif/detail/${balita.id}">
                                        <small>${balita.name}</small>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <small>${balita.gender}</small>
                                </td>
                                <td>
                                    <small>${balita.umur_display}</small>
                                </td>
                                <td>
                                    <small>${balita.status}</small>
                                </td>
                            </tr>`);
                    });
                }

                // Tambahkan data balita Aktif ke dalam tabel
                if (orangtua.balita && orangtua.balita.length > 0) {
                    orangtua.balita.forEach(function(balita) {
                        $('#balita_table_body').append(`
                            <tr>
                                <td class="text-center">
                                    <small>${balita.family_order}</small>
                                </td>
                                <td>
                                    <a href="/pengukuran/detail/${balita.id}">
                                        <small>${balita.name}</small>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <small>${balita.gender}</small>
                                </td>
                                <td>
                                    <small>${balita.umur_display}</small>
                                </td>
                                <td>
                                    <small>${balita.status}</small>
                                </td>
                            </tr>`);
                    });
                } else {
                    $('#balita_table_body').append(`
                            <tr>
                                <td colspan="5" class="text-center"><em>Tidak ada data balita aktif</em></td>
                            </tr>`);
                }

                // Tampilkan modal
                $('#ortuModal').modal('show');
            });
        });
    </script>
@endsection
