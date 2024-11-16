@extends('layout.main', ['title' => 'Tambah Pengukuran Balita'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



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
                        <form id="form" action="{{ route('balitaukur.hitung') }}" method="POST"
                            class="form form-horizontal">
                            @csrf
                            <div class="form-body">

                                {{-- tanda wajib diisi --}}
                                {{-- <span style="color: #dc3545;">*</span> --}}

                                {{-- Form Nama Balita --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Nama Balita</label>
                                    </div>
                                    <div class="col-md-4 form-group mt-2">
                                        <select id="balitaSelect" name="balita_id"
                                            class="form-select select2 @error('balita_id') is-invalid @enderror"
                                            data-placeholder="Pilih Nama Balita">
                                            <option></option>
                                            @foreach ($balitas as $balita)
                                                <option value="{{ $balita->id }}"
                                                    {{ count($balitas) === 1 || old('balita_id') == $balita->id ? 'selected' : '' }}>
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
                                                <p class="badge bg-light-secondary form-control-static fw-normal"
                                                    id="tgl_lahir">-
                                                </p>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label class="medium-text" for="jenis_kelamin">Jenis Kelamin
                                                    :</label><br>
                                                <p class="badge bg-light-secondary form-control-static fw-normal "
                                                    id="jenis_kelamin">
                                                    -
                                                </p>
                                            </div>
                                            <div class="col-6 col-md-5">
                                                <label class="medium-text" for="umur">Umur saat Ini :</label><br>
                                                <p class="badge bg-light-secondary form-control-static fw-normal "
                                                    id="umur">-
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
                                    <div class="col-md-3 form-group mt-2  position-relative has-icon-left">
                                        <input name="tgl_ukur" id="tgl_ukur" type="text"
                                            class="form-control @error('tgl_ukur') is-invalid @enderror"
                                            value="{{ old('tgl_ukur') }}" placeholder="Pilih tanggal..">
                                        <div class="form-control-icon ms-3 ">
                                            <i class="fa-regular fa-calendar"></i>
                                        </div>
                                        <div class="invalid-feedback">
                                            @error('tgl_ukur')
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
                                            <div class="col-2 p-0 justify-content-start mt-2">
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
                                            <div class="col-2 p-0 justify-content-start mt-2">
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
                                            <input name="cara_ukur" value="Berbaring"
                                                class="form-check-input @error('cara_ukur') is-invalid @enderror"
                                                type="radio" id="radioBerbaring"
                                                {{ old('cara_ukur') == 'Berbaring' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="radioBerbaring">Berbaring</label>
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
                                        class="btn btn-primary me-3 mb-1">Hitung</button>
                                    <button id="resetButton" type="reset"
                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="zscoreModal" tabindex="-1" aria-labelledby="zscoreModalLabel"
                aria-hidden="true" data-bs-backdrop="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title white" id="zscoreModalLabel">Hasil Pengukuran Balita</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-7 col-md-6">
                                            <label class="medium-text">Nama Balita :</label><br>
                                            <p class="badge bg-light-secondary form-control-static fw-normal"
                                                id="balita_name"></p><br>
                                            <label class="medium-text">Tanggal Pengukuran :</label><br>
                                            <p class="badge bg-light-secondary form-control-static fw-normal"
                                                id="tgl_ukur1"></p><br>
                                            <label class="medium-text">Umur Pengukuran :</label><br>
                                            <p class="badge bg-light-secondary form-control-static fw-normal"
                                                id="umur_ukur"></p>

                                        </div>
                                        <div class="col-5 col-md-6">
                                            <label class="medium-text">Berat Badan :</label><br>
                                            <p class="badge bg-light-secondary form-control-static fw-normal"
                                                id="bb"> kg</p><br>
                                            <label class="medium-text">Tinggi Badan :</label><br>
                                            <p class="badge bg-light-secondary form-control-static fw-normal"
                                                id="tb"> cm</p><br>
                                            <label class="medium-text">Cara Pengukuran :</label><br>
                                            <p class="badge bg-light-secondary form-control-static fw-normal"
                                                id="cara_ukur"></p><br>

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
                                        <div class="col-2 col-md-3">
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
                                        <div class="col-2 col-md-3">
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
                                        <div class="col-2 col-md-3">
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
                                        <div class="col-2 col-md-3">
                                            <span id="zscore_imt_u"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="saveBtn" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>







    </div>
@endsection
@section('jsLibraries')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

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


        // CONFIG FLATPICKR
        flatpickr("#tgl_ukur", {

            "locale": "id",
            altInput: true,
            altFormat: "j F Y",
            maxDate: "today",


        });
        // CONFIG FLATPICKR
        flatpickr(".flatpickr", {

            "locale": "id",
            altInput: true,
            altFormat: "j F Y",
            maxDate: "today",


        });
    </script>


    {{-- Script info tgl lahir, umur, gender balita --}}
    <script>
        $(document).ready(function() {
            // Mengirim data balita dari Laravel ke JavaScript
            const balitaData = @json($balitas);

            // Fungsi untuk menampilkan data balita
            function displayBalitaInfo(selectedId) {
                const selectedBalita = balitaData.find(balita => balita.id == selectedId);

                if (selectedBalita) {
                    document.getElementById("tgl_lahir").innerText = selectedBalita.tgl_lahir_display;
                    document.getElementById("umur").innerText = selectedBalita.umur_display;
                    document.getElementById("jenis_kelamin").innerText = selectedBalita.gender_display;
                } else {
                    // Reset ke nilai default jika tidak ada balita yang dipilih
                    document.getElementById("tgl_lahir").innerText = "-";
                    document.getElementById("umur").innerText = "-";
                    document.getElementById("jenis_kelamin").innerText = "-";
                }
            }

            // Panggil fungsi saat halaman dimuat untuk menampilkan info jika ada balita yang sudah dipilih
            const initialSelectedId = $('#balitaSelect').val();
            displayBalitaInfo(initialSelectedId);

            // Event handler untuk saat pilihan diubah
            $('#balitaSelect').change(function() {
                const selectedId = this.value; // Mendapatkan ID yang dipilih
                displayBalitaInfo(selectedId);
            });
        });
    </script>

    {{-- Loading Tombol Submit --}}
    {{-- <script>
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
    </script> --}}

    <script>
        // Fungsi untuk menampilkan data di modal
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah form submit default

            // Nonaktifkan tombol selama proses penghitungan
            this.disabled = true;
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghitung...';

            var formData = new FormData(document.getElementById('form')); // Ambil data form

            fetch("{{ route('balitaukur.hitung') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Aktifkan kembali tombol dan kembalikan teks aslinya
                    document.getElementById('submitBtn').disabled = false;
                    document.getElementById('submitBtn').innerHTML = 'Hitung';

                    if (data) {
                        // Tampilkan data di modal
                        document.getElementById('balita_name').innerText = data.balita_name;
                        document.getElementById('tgl_ukur1').innerText = data.tgl_ukur;
                        document.getElementById('umur_ukur').innerText = data.umur_ukur;
                        document.getElementById('bb').innerText = data.bb + " kg";
                        document.getElementById('tb').innerText = data.tb + " cm";
                        document.getElementById('cara_ukur').innerText = data.cara_ukur;
                        document.getElementById('zscore_bb_u').innerText = data.zscore_bb_u;
                        document.getElementById('status_bb_u').innerText = data.status_bb_u;
                        document.getElementById('status_bb_u').className = 'badge ' + getStatusClass(data
                            .status_bb_u);
                        document.getElementById('zscore_tb_u').innerText = data.zscore_tb_u;
                        document.getElementById('status_tb_u').innerText = data.status_tb_u;
                        document.getElementById('status_tb_u').className = 'badge ' + getStatusClass(data
                            .status_tb_u);
                        document.getElementById('zscore_bb_tb').innerText = data.zscore_bb_tb;
                        document.getElementById('status_bb_tb').innerText = data.status_bb_tb;
                        document.getElementById('status_bb_tb').className = 'badge ' + getStatusClass(data
                            .status_bb_tb);
                        document.getElementById('zscore_imt_u').innerText = data.zscore_imt_u;
                        document.getElementById('status_imt_u').innerText = data.status_imt_u;
                        document.getElementById('status_imt_u').className = 'badge ' + getStatusClass(data
                            .status_imt_u);

                        // Tampilkan modal
                        var myModal = new bootstrap.Modal(document.getElementById('zscoreModal'));
                        myModal.show();
                    } else {
                        alert('Terjadi kesalahan saat mengambil data.');
                    }
                })
                .catch(error => {
                    // Aktifkan kembali tombol dan kembalikan teks aslinya jika terjadi error
                    document.getElementById('submitBtn').disabled = false;
                    document.getElementById('submitBtn').innerHTML = 'Hitung';

                    console.error('Error:', error);
                    alert('Terjadi kesalahan, silakan coba lagi.');
                });
        });

        // Fungsi untuk mengembalikan class badge berdasarkan status
        function getStatusClass(status) {
            switch (status) {
                case 'Berat badan normal':
                case 'Normal':
                case 'Gizi baik':
                case 'Beresiko gizi lebih':
                    return 'bg-light-success';
                case 'Berat badan kurang':
                case 'Resiko berat badan lebih':
                case 'Pendek':
                case 'Gizi kurang':
                case 'Gizi lebih':
                    return 'bg-light-warning';
                case 'Berat badan sangat kurang':
                case 'Sangat pendek':
                case 'Tinggi':
                case 'Gizi buruk':
                case 'Obesitas':
                    return 'bg-light-danger';
                default:
                    return 'bg-secondary';
            }
        }

        // Fungsi untuk mengirim data simpan ke controller
        document.getElementById('saveBtn').addEventListener('click', function() {
            // Nonaktifkan tombol selama proses penyimpanan
            this.disabled = true;
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

            // Data yang dikirim ke controller untuk disimpan
            var formData = {
                balita_id: document.getElementById('balita_name').innerText,
                zscore_bb_u: document.getElementById('zscore_bb_u').innerText,
                zscore_tb_u: document.getElementById('zscore_tb_u').innerText,
                zscore_bb_tb: document.getElementById('zscore_bb_tb').innerText,
                zscore_imt_u: document.getElementById('zscore_imt_u').innerText,
                status_bb_u: document.getElementById('status_bb_u').innerText,
                status_tb_u: document.getElementById('status_tb_u').innerText,
                status_bb_tb: document.getElementById('status_bb_tb').innerText,
                status_imt_u: document.getElementById('status_imt_u').innerText
            };

            fetch("{{ route('balitaukur.simpanZScore') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    // Aktifkan kembali tombol dan kembalikan teks aslinya
                    document.getElementById('saveBtn').disabled = false;
                    document.getElementById('saveBtn').innerHTML = 'Simpan';

                    if (data.success) {
                        alert('Data berhasil disimpan!');
                        var myModal = bootstrap.Modal.getInstance(document.getElementById('zscoreModal'));
                        myModal.hide();
                    } else {
                        alert('Terjadi kesalahan saat menyimpan data.');
                    }
                })
                .catch(error => {
                    // Aktifkan kembali tombol dan kembalikan teks aslinya jika terjadi error
                    document.getElementById('saveBtn').disabled = false;
                    document.getElementById('saveBtn').innerHTML = 'Simpan';

                    console.error('Error:', error);
                    alert('Terjadi kesalahan, silakan coba lagi.');
                });
        });
    </script>
@endsection
