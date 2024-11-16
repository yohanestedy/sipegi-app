@extends('layout.main', ['title' => 'Tambah Data Balita'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}">
                                        <div class="invalid-feedback">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form NIK --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end mt-3">
                                        <label>NIK Balita</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="nik" id="nikHidden" type="hidden" value="">
                                        <input name="nik" type="number" id="nik-input"
                                            class="form-control @error('nik') is-invalid @enderror"
                                            value="{{ old('nik') }}">
                                        <div class="invalid-feedback">
                                            @error('nik')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="disableNIK"
                                                name="disableNIK" {{ old('disableNIK') ? 'checked' : '' }}>
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
                                    <div class="col-md-3 form-group mt-2 position-relative has-icon-left">
                                        <input id="tgl_lahir2" name="tgl_lahir" type="text"
                                            class="form-control @error('tgl_lahir') is-invalid @enderror"
                                            value="{{ old('tgl_lahir') }}" placeholder="Pilih tanggal..">
                                        <div class="form-control-icon ms-3 ">
                                            <i class="fa-regular fa-calendar"></i>
                                        </div>
                                        <div class="invalid-feedback">
                                            @error('tgl_lahir')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Jenis Kelamin --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 text-md-end justify-content-end">
                                        <label>Jenis Kelamin</label>
                                    </div>
                                    <div class="col-md-7 form-group">
                                        <div class="form-check">
                                            <input name="gender" value="L"
                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                type="radio" id="radioLakilaki"
                                                {{ old('gender') == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="radioLakilaki"
                                                style="font-weight: normal;">
                                                Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="gender" value="P"
                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                type="radio" id="radioPerempuan"
                                                {{ old('gender') == 'P' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="radioPerempuan"
                                                style="font-weight: normal;">
                                                Perempuan
                                            </label>

                                            <div class="invalid-feedback">
                                                @error('gender')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Nama Orangtua --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Nama Orangtua</label>
                                    </div>
                                    <div class="col-md-7 form-group mt-2">
                                        <select id="orangtuaSelect" name="orangtua"
                                            class="form-select select2 @error('orangtua') is-invalid @enderror"
                                            data-placeholder="Pilih Nama Orangtua">
                                            <option></option>
                                            @foreach ($orangtua as $orangtua)
                                                <option value="{{ $orangtua->id }}"
                                                    data-dusun-id="{{ $orangtua->dusun_id }}"
                                                    {{ old('orangtua') == $orangtua->id ? 'selected' : '' }}>
                                                    {{ $orangtua->name }} -
                                                    {{ $orangtua->nik }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('orangtua')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Posyandu --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Posyandu</label>
                                    </div>
                                    <div class="col-md-4 form-group mt-2">
                                        <select id="posyanduSelect" name="posyandu"
                                            class="form-select select2  @error('posyandu') is-invalid @enderror"
                                            data-placeholder="Pilih Posyandu" data-old-value="{{ old('posyandu') }}">
                                            <option></option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('posyandu')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                {{-- Form Anak Ke Berapa --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Anak ke berapa</label>
                                    </div>
                                    <div class="col-12 col-md-5 form-group mt-2">
                                        <div class="row d-flex">
                                            <div class="col-10 col-md-5">
                                                <input name="family_order" type="number"
                                                    class="form-control @error('family_order') is-invalid @enderror"
                                                    value="{{ old('family_order') }}">
                                                <div class="invalid-feedback">
                                                    @error('family_order')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-2 p-0 justify-content-start mt-auto"></div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Form Berat Badan saat Lahir --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Berat Badan saat Lahir</label>
                                    </div>
                                    <div class="col-12 col-md-5 form-group mt-2">
                                        <div class="row d-flex">
                                            <div class="col-10 col-md-5">
                                                <input name="bb_lahir" type="number"
                                                    class="form-control  @error('bb_lahir') is-invalid @enderror"
                                                    value="{{ old('bb_lahir') }}">
                                                <div class="invalid-feedback">
                                                    @error('bb_lahir')
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
                                {{-- Form Panjang Badan saat Lahir --}}
                                <div class="row d-flex mb-4">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label>Panjang Badan saat Lahir</label>
                                    </div>
                                    <div class="col-12 col-md-5 form-group mt-2">
                                        <div class="row d-flex">
                                            <div class="col-10 col-md-5">
                                                <input name="tb_lahir" type="number"
                                                    class="form-control @error('tb_lahir') is-invalid @enderror"
                                                    value="{{ old('tb_lahir') }}">
                                                <div class="invalid-feedback">
                                                    @error('tb_lahir')
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <script>
        // CONFIG FLATPICKR
        flatpickr("#tgl_lahir2", {

            "locale": "id",
            altInput: true,
            altFormat: "j F Y",
            maxDate: "today",

        });
    </script>

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

        document.getElementById('disableNIK').onchange();
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
