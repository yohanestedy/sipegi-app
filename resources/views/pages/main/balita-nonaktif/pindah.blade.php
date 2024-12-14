@extends('layout.main', ['title' => 'Balita Pindah Keluar'])

@section('cssLibraries')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('/assets/compiled/css/table-datatable-jquery.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
                <a href="#">Balita Nonaktif</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Pindah Keluar
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Balita Pindah Keluar</h3>
                    <p class="text-subtitle text-muted">Adalah balita yang Pindah/Keluar dari Posyandu atau Desa Selorejo.
                    </p>
                </div>

            </div>
        </div>
        <section class="section">

            {{-- FORM BALITA PINDAH --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Balita Pindah Keluar</h4>
                </div>
                <div class="card-body">

                    <form id="formPindahKeluar" method="POST" action="{{ route('balitanonaktif.store-pindahkeluar') }}"
                        class="form form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <select id="balitaSelect" name="balita_id"
                                    class="form-select select2 @error('balita_id') is-invalid @enderror"
                                    data-placeholder="--Pilih Nama Balita--" required>
                                    <option></option>
                                    @foreach ($balitasAktif as $balita)
                                        <option value="{{ $balita->id }}"
                                            {{ old('balita_id') == $balita->id ? 'selected' : '' }}>
                                            {{ $balita->name }} - {{ $balita->posyandu->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('balita_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-5 mb-3">

                                <div class="form-check mt-2">
                                    <div class="checkbox">
                                        <input type="checkbox" id="iaggree" class="form-check-input">
                                        <label for="iaggree">Sentuh saya! jika nama yang di pilih sudah benar.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <button id="btn-pindahkan" type="submit" class="btn btn-danger w-100 swal-delete"
                                    disabled><i class="fa-regular fa-circle-x me-1"></i>
                                    Nonaktifkan</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>

            {{-- TABEL --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Daftar Balita yang sudah Pindah Keluar
                    </h5>
                    {{-- <a href="{{ route('balita.add') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </a> --}}
                </div>
                <div class="card-body">

                    <div class="mb-2">
                        <p class="d-block d-xl-none"
                            style="font-size: 0.85rem; color: #9d9e9f; font-weight: 500; margin-top: 8px; font-style: italic; text-align: left;">
                            *Geser ke samping untuk melihat data
                        </p>
                    </div>
                    <div class="table-responsive datatable-minimal">

                        <table class="table table-hover table-bordered medium-text" id="tableBalitaLulus">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Tindakan</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">NIK</th>
                                    <th style="text-align: center;">Jenis Kelamin</th>
                                    <th style="text-align: center;">Tanggal Lahir</th>
                                    <th style="text-align: center;">Umur</th>
                                    <th style="text-align: center;">Nama Orangtua</th>
                                    <th style="text-align: center;">Posyandu</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($balitas as $balita)
                                    <tr>

                                        <td style="text-align: center">
                                            <a href="{{ route('balitanonaktif.detail', ['id' => $balita->id]) }}"
                                                class="btn icon btn-primary " data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Riwayat Pengukuran"
                                                style="border-radius: 8px; padding: .2rem .4rem;">
                                                <i class="fa-regular fa-list-check"></i></a></a>
                                            <a href="{{ route('balita.edit', ['id' => $balita->id]) }}"
                                                class="btn icon btn-success " data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Edit"
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
                                        <td>{{ $balita->name }}</td>
                                        <td style="text-align: center">{{ $balita->nik == null ? '-' : $balita->nik }}</td>
                                        <td style="text-align: center">
                                            <div style="font-weight: 600; {{ $balita->gender_display == 'Perempuan' ? 'background-color: #fcd8ff; color:#855f82' : 'background-color: #d2eeff; color: #526483' }} "
                                                class="badge">
                                                {{ $balita->gender_display }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($balita->tgl_lahir)->translatedFormat('d F Y') }}</td>
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
@endsection

@section('jsLibraries')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('.select2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>

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
                    title: "Nonaktifkan Balita Meninggal?",
                    text: "Pastikan nama balita yang anda pilih sudah benar!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#9c9c9c",
                    confirmButtonText: "Ya, Nonaktifkan!",
                    cancelButtonText: "Batal",
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        document.getElementById('formPindahKeluar')
                            .submit(); // Submit form setelah konfirmasi
                    }
                });
            });




        });
    </script>

    {{-- Ceklis Delete --}}
    <script>
        const checkbox = document.getElementById("iaggree")
        const buttonPindahkan = document.getElementById("btn-pindahkan")
        checkbox.addEventListener("change", function() {
            const checked = checkbox.checked
            if (checked) {
                buttonPindahkan.removeAttribute("disabled")
            } else {
                buttonPindahkan.setAttribute("disabled", true)
            }
        })
    </script>
@endsection
