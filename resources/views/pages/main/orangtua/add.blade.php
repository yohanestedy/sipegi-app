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

                    <h3>Tambah Data Orangtua</h3>
                    <p class="text-subtitle text-muted">
                        Isi form untuk menambah data orangtua.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('orangtua.index') }}">Orangtua</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tambah Data Orangtua
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
                        <form id="form" action="{{ route('orangtua.store') }}" method="POST"
                            class="form form-horizontal">
                            @csrf
                            <div class="form-body">

                                {{-- Form Nomor KK  --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="no_kk">Nomor KK <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="no_kk" type="number" id="no_kk" class="form-control"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form NIK Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="nik">NIK Orangtua <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="nik" type="number" id="nik" class="form-control"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form Nama Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="nameOrtu">Nama Orangtua <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="name" type="text" id="nameOrtu" class="form-control"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form Telp/HP Orangtua --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="telp">Telp/HP Orangtua <span
                                                style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="telp" type="number" id="telp" class="form-control"
                                            placeholder="">
                                    </div>
                                </div>
                                {{-- Form Provinsi --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label>Provinsi <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select name="provinsi" class="form-select select2"
                                            data-placeholder="Pilih Provinsi">
                                            <option></option>
                                            <option value="Lampung">Lampung</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Kabupaten --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label>Kabupaten <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select name="kabupaten" class="form-select select2"
                                            data-placeholder="Pilih Kabupaten">
                                            <option></option>
                                            <option value="Lampung Timur">Lampung Timur</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Kecamatan --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label>Kecamatan <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select name="kecamatan" class="form-select select2"
                                            data-placeholder="Pilih Kecamatan">
                                            <option></option>
                                            <option value="Batanghari">Batanghari</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Desa --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label>Desa <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select name="desa" class="form-select select2" data-placeholder="Pilih Desa">
                                            <option></option>
                                            <option value="Selorejo">Selorejo</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Form Dusun --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="dusun">Dusun <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select id="dusun" name="dusun" class="form-select select2"
                                            data-placeholder="Pilih Dusun">
                                            <option></option>
                                            @foreach ($dusuns as $dusun)
                                                <option value="{{ $dusun->id }}">{{ $dusun->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Form RT --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="rt">RT <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select id="rt" name="rt" class="form-select select2"
                                            data-placeholder="Pilih RT" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form RW --}}
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label for="rw">RW <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select id="rw" name="rw" class="form-select select2"
                                            data-placeholder="Pilih RW" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>


                                {{-- Form Alamat Lengkap --}}
                                <div class="row d-flex mb-3 ">
                                    <div class="col-md-4 mt-2 text-md-end justify-content-end">
                                        <label>Alamat Lengkap <span style="color: #dc3545;">*</span></label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>

                                {{-- Tombol Simpan --}}
                                <div class="col-sm-12 d-flex justify-content-center">
                                    <button id="submitBtn" type="submit"
                                        class="btn btn-primary me-3 mb-1">Simpan</button>
                                    <button id="resetButton" type="reset"
                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>

                                @if (session('success'))
                                    <script>
                                        console.log("{{ session('success') }}");
                                    </script>
                                @endif

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('jsLibraries')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('.select2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });

        // Reset select2
        $('#resetButton').on('click', function() {
            $('.select2').val(null).trigger('change');
        });
    </script>

    {{-- Loading Tombol Submit --}}
    <script>
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah submit default agar kita bisa menambahkan efek loading

            // Nonaktifkan tombol saat loading
            this.disabled = true;

            // Tambahkan spinner ke dalam tombol
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';


            // Setelah efek loading, lanjutkan dengan submit form
            setTimeout(() => {
                // Kirim form secara manual setelah animasi loading selesai
                document.getElementById('form').submit();
                this.innerHTML = 'Masuk';
                this.disabled = false;

            }, 700);


            // Sesuaikan durasi loading (misalnya 500 ms)
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dusun').change(function() {
                const dusunId = $(this).val();

                // Reset RT dan RW dropdown
                $('#rt').empty().append('<option></option>').prop('disabled', true);
                $('#rw').empty().append('<option></option>').prop('disabled', true);

                if (dusunId) {
                    // Ambil RT berdasarkan dusun yang dipilih
                    $.ajax({
                        url: `/api/rt/${dusunId}`,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, rt) {
                                $('#rt').append(new Option(rt.rt, rt.id));
                            });
                            $('#rt').prop('disabled', false);
                        }
                    });

                    // Ambil RW berdasarkan dusun yang dipilih
                    $.ajax({
                        url: `/api/rw/${dusunId}`,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, rw) {
                                $('#rw').append(new Option(rw,
                                    rw)); // Ambil RW dari response
                            });
                            $('#rw').prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection
