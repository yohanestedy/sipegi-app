@extends('layout.main', ['title' => 'Tambah Pengukuran Balita'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .medium-text {
            font-size: 0.8rem;
            /* Ukuran medium */
        }
    </style>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">

                    <h3>Tambah Pengukuran Balita</h3>
                    <p class="text-subtitle text-muted">
                        Isi form untuk menambah Pengukuran balita.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Balita</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tambah Pengukuran Balita
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
                        <form id="form" action="#" method="POST" class="form form-horizontal">
                            @csrf
                            <div class="form-body">

                                {{-- tanda wajib diisi --}}
                                {{-- <span style="color: #dc3545;">*</span> --}}

                                {{-- Form Nama Balita --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Nama Balita</label>
                                    </div>
                                    <div class="col-md-6 form-group mt-2">
                                        <select id="balitaSelect" name="name"
                                            class="form-select select2 @error('name') is-invalid @enderror"
                                            data-placeholder="Pilih Nama Balita">
                                            <option></option>
                                            @foreach ($balitas as $balita)
                                                <option value="{{ $balita->id }}"
                                                    {{ old('name') == $balita->id ? 'selected' : '' }}>
                                                    {{ $balita->name }} - {{ $balita->posyandu->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Informasi Balita (Tanggal Lahir, Umur, Jenis Kelamin) -->
                                <div class="row ">
                                    <div class="col-md-4 text-md-end mt-3">
                                        {{-- <label class="form-label">Informasi Balita</label> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <label class="medium-text" for="tgl_lahir">Tanggal Lahir
                                                    :</label><br>
                                                <p class="badge bg-light-secondary form-control-static " id="tgl_lahir">-
                                                </p>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label class="medium-text" for="umur">Umur :</label><br>
                                                <p class="badge bg-light-secondary form-control-static " id="umur">-
                                                </p>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label class="medium-text" for="jenis_kelamin">Jenis Kelamin
                                                    :</label><br>
                                                <p class="badge bg-light-secondary form-control-static " id="jenis_kelamin">
                                                    -
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Tanggal Ukur --}}
                                <div class="row d-flex mb-2">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Tanggal Ukur</label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <input name="tgl_ukur" type="date"
                                            class="form-control @error('tgl_ukur') is-invalid @enderror"
                                            value="{{ old('tgl_ukur') }}">
                                        <div class="invalid-feedback">
                                            @error('tgl_lahir')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form BB --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Berat Badan</label>
                                    </div>
                                    <div class="col-12 col-md-5 form-group mt-2">
                                        <div class="row d-flex">
                                            <div class="col-10 col-md-5">
                                                <input name="bb" type="number"
                                                    class="form-control  @error('bb') is-invalid @enderror"
                                                    value="{{ old('bb') }}">
                                                <div class="invalid-feedback">
                                                    @error('bb')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-2 p-0 justify-content-start mt-auto">
                                                <label style="font-weight: 350; font-size: 1.2em">kg</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Form TB --}}
                                <div class="row mb-2 d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Tinggi Badan</label>
                                    </div>
                                    <div class="col-12 col-md-5 form-group mt-2">
                                        <div class="row d-flex">
                                            <div class="col-10 col-md-5">
                                                <input name="tb" type="number"
                                                    class="form-control  @error('tb') is-invalid @enderror"
                                                    value="{{ old('tb') }}">
                                                <div class="invalid-feedback">
                                                    @error('tb')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-2 p-0 justify-content-start mt-auto">
                                                <label style="font-weight: 350; font-size: 1.2em">cm</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Form TB --}}
                                {{-- <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Tinggi Badan(cm)</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input name="tb_lahir" type="number"
                                            class="form-control @error('tb_lahir') is-invalid @enderror"
                                            value="{{ old('tb_lahir') }}">
                                        <div class="invalid-feedback">
                                            @error('tb_lahir')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Cara Ukur -->
                                <div class="row mb-4">
                                    <div class="col-md-4 text-md-end">
                                        <label class="form-label">Cara Ukur</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-check form-check-inline">
                                            <input name="cara_ukur" value="Berdiri"
                                                class="form-check-input @error('cara_ukur') is-invalid @enderror"
                                                type="radio" id="radioBerdiri"
                                                {{ old('cara_ukur') == 'Berdiri' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="radioBerdiri">Berdiri</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="cara_ukur" value="Terlentang"
                                                class="form-check-input @error('cara_ukur') is-invalid @enderror"
                                                type="radio" id="radioTerlentang"
                                                {{ old('cara_ukur') == 'Terlentang' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="radioTerlentang">Terlentang</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            @error('cara_ukur')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Simpan --}}
                                <div class="col-sm-12 d-flex justify-content-center">
                                    <button id="submitBtn" type="submit"
                                        class="btn btn-primary me-3 mb-1">Simpan</button>
                                    <button id="resetButton" type="reset"
                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>

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

    <script>
        $(document).ready(function() {
            // Mengirim data balita dari Laravel ke JavaScript
            const balitaData = @json($balitas);

            $('#balitaSelect').change(function() {
                const selectedId = this.value; // Mendapatkan ID yang dipilih
                const selectedBalita = balitaData.find(balita => balita.id ==
                    selectedId); // Mencari balita berdasarkan ID

                // Menampilkan informasi balita jika ditemukan, jika tidak, reset ke default
                if (selectedBalita) {
                    document.getElementById("tgl_lahir").innerText = selectedBalita
                        .tgl_lahir_display; // Menggunakan atribut baru
                    document.getElementById("umur").innerText = selectedBalita
                        .umur_display; // Menggunakan umur_display
                    document.getElementById("jenis_kelamin").innerText = selectedBalita
                        .gender_display; // Menggunakan gender_display
                } else {
                    // Reset ke nilai default jika tidak ada balita yang dipilih
                    document.getElementById("tgl_lahir").innerText = "-";
                    document.getElementById("umur").innerText = "-";
                    document.getElementById("jenis_kelamin").innerText = "-";
                }
            });
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
                this.innerHTML = 'Simpan';
                this.disabled = false;

            }, 700);


            // Sesuaikan durasi loading (misalnya 500 ms)
        });
    </script>
@endsection
