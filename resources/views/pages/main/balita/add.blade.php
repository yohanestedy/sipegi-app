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

                    <h3>Tambah Data Balita</h3>
                    <p class="text-subtitle text-muted">
                        Isi form untuk menambah data balita.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Balita</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tambah Data Balita
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
                        <form id="form" action="{{ route('balita.store') }}" method="POST"
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
                                    <div class="col-md-5 form-group mt-2">
                                        <input type="text" class="form-control" name="name" placeholder="">
                                    </div>
                                </div>

                                {{-- Form NIK --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end mt-3">
                                        <label>NIK Balita</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="nik" id="nikHidden" type="hidden" value="">
                                        <input name="nik" type="number" id="nik-input" class="form-control"
                                            placeholder="">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="disableNIK">
                                            <label class="form-check-label" for="disableNIK" style="font-weight: normal;">
                                                Ceklist jika Balita belum mempunyai NIK
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Tanggal Lahir --}}
                                <div class="row d-flex mb-2">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Tanggal Lahir</label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <input name="dateofbirth" type="date" class="form-control" name="birthdate"
                                            placeholder="">
                                    </div>
                                </div>

                                {{-- Form Jenis Kelamin --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label>Jenis Kelamin</label>
                                    </div>
                                    <div class="col-md-7 form-group">
                                        <div class="form-check">
                                            <input name="gender" value="Laki-laki" class="form-check-input" type="radio"
                                                id="radioLakilaki">
                                            <label class="form-check-label" for="radioLakilaki"
                                                style="font-weight: normal;">
                                                Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="gender" value="Perempuan" class="form-check-input" type="radio"
                                                id="radioPerempuan">
                                            <label class="form-check-label" for="radioPerempuan"
                                                style="font-weight: normal;">
                                                Perempuan
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Nama Orangtua --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Nama Orangtua</label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select id="orangtuaSelect" name="orangtua" class="form-select select2"
                                            data-placeholder="Pilih Nama Orangtua">
                                            <option></option>
                                            @foreach ($orangtua as $orangtua)
                                                <option value="{{ $orangtua->id }}"
                                                    data-dusun-id="{{ $orangtua->dusun_id }}">{{ $orangtua->name }} -
                                                    {{ $orangtua->nik }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Posyandu --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Posyandu</label>
                                    </div>
                                    <div class="col-md-4 form-group mt-2">
                                        <select id="posyanduSelect" name="posyandu" class="form-select select2"
                                            data-placeholder="Pilih Posyandu" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Anak Ke Berapa --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Anak ke berapa?</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input name="fam_order" type="number" class="form-control" placeholder="">
                                    </div>
                                </div>

                                {{-- Form BB saat Lahir --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Berat Badan saat lahir(kg)</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input name="birth_weight" type="number" class="form-control" placeholder="">
                                    </div>
                                </div>

                                {{-- Form PB saat Lahir --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Panjang Badan saat lahir(cm)</label>
                                    </div>
                                    <div class="col-md-2 form-group mt-2">
                                        <input name="birth_length" type="number" class="form-control" placeholder="">
                                    </div>
                                </div>

                                {{-- Tombol Simpan --}}
                                <div class="col-sm-12 d-flex justify-content-center">
                                    <button id="submitBtn" type="submit"
                                        class="btn btn-primary me-3 mb-1">Simpan</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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


        // JS Value NIK
        document.getElementById('disableNIK').onchange = function() {
            var nikInput = document.getElementById('nik-input');
            var nikHidden = document.getElementById('nikHidden');
            if (this.checked) {

                nikInput.disabled = true;
                nikInput.value = '';
                nikHidden.value = null;
            } else {
                nikInput.disabled = false;
                nikHidden.value = nikInput.value;
            }
        };
    </script>

    {{-- GET POSYANDU BY DUSUN ID ON ORANGTUA --}}
    <script>
        $(document).ready(function() {
            $('#orangtuaSelect').change(function() {
                const dusunId = $(this).find(':selected').data(
                    'dusun-id'); // Ambil dusun_id dari opsi yang dipilih

                // Reset dropdown posyandu
                $('#posyanduSelect').empty().append('<option></option>').prop('disabled', true);

                if (dusunId) {
                    // Ambil posyandu berdasarkan dusun_id yang dipilih
                    $.ajax({
                        url: `/api/posyandu/${dusunId}`, // URL API yang sesuai
                        method: 'GET',
                        success: function(data) {
                            const oldPosyandu = $('#posyanduSelect').data(
                                'old-value'); // Ambil nilai lama jika ada

                            // Jika data posyandu ada, tambahkan ke dropdown
                            if (data) {
                                $('#posyanduSelect').append(new Option(data.name, data.id));
                            }

                            $('#posyanduSelect').prop('disabled', false); // Aktifkan dropdown

                            // Pilih nilai lama jika ada
                            if (oldPosyandu) {
                                $('#posyanduSelect').val(oldPosyandu).trigger('change');
                            }
                        },
                        error: function() {
                            // Handle error jika diperlukan
                            alert('Gagal memuat data posyandu. Silakan coba lagi.');
                        }
                    });
                }
            });

            // Trigger perubahan ketika halaman dimuat untuk mengisi nilai lama, jika ada
            if ($('#orangtuaSelect').val()) {
                $('#orangtuaSelect').trigger('change');
            }
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
