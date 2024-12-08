@extends('layout.main', ['title' => 'Edit Data Balita'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('orangtua.index') }}">Orangtua</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit Data Orangtua
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">

                    <h3>Edit Data Orangtua</h3>
                    <p class="text-subtitle text-muted">
                        Edit form untuk merubah data orangtua.
                    </p>
                </div>
            </div>
        </div>
        <section class="section col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form id="form" action="{{ route('orangtua.update', ['id' => $orangtua->id]) }}" method="POST"
                            class="form form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                {{-- <span style="color: #dc3545;">*</span> --}}

                                {{-- Form Nomor KK  --}}
                                <div class="row d-flex">
                                    <div class="col-md-4 mt-3 text-md-end justify-content-end">
                                        <label for="no_kk">Nomor KK</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="no_kk" type="number" id="no_kk"
                                            class="form-control @error('no_kk') is-invalid @enderror"
                                            value="{{ old('no_kk') ?? $orangtua->no_kk }}">
                                        <div class="invalid-feedback">
                                            @error('no_kk')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form NIK Ibu --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="nik_ibu">NIK Ibu</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="nik_ibu" type="number" id="nik_ibu"
                                            class="form-control  @error('nik_ibu') is-invalid @enderror"
                                            value="{{ old('nik_ibu') ?? $orangtua->nik_ibu }}">
                                        <div class="invalid-feedback">
                                            @error('nik_ibu')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Nama Ibu --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="name_ibu">Nama Ibu</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="name_ibu" type="text" id="name_ibu"
                                            class="form-control @error('name_ibu') is-invalid @enderror"
                                            value="{{ old('name_ibu') ?? $orangtua->name_ibu }}">
                                        <div class="invalid-feedback">
                                            @error('name_ibu')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form NIK Ayah --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="nik_ayah">NIK Ayah</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="nik_ayah" type="number" id="nik_ayah"
                                            class="form-control  @error('nik_ayah') is-invalid @enderror"
                                            value="{{ old('nik_ayah') ?? $orangtua->nik_ayah }}">
                                        <div class="invalid-feedback">
                                            @error('nik_ayah')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Nama Ayah --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="name_ayah">Nama Ayah</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="name_ayah" type="text" id="name_ayah"
                                            class="form-control @error('name_ayah') is-invalid @enderror"
                                            value="{{ old('name_ayah') ?? $orangtua->name_ayah }}">
                                        <div class="invalid-feedback">
                                            @error('name_ayah')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Telp/HP Orangtua --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="telp">Telp/HP Orangtua</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <input name="telp" type="number" id="telp"
                                            class="form-control @error('telp') is-invalid @enderror"
                                            value="{{ old('telp') ?? $orangtua->telp }}">
                                        <div class="invalid-feedback">
                                            @error('telp')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                {{-- Alamat Domisili Label --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">

                                    </div>
                                    <div class="col-md-5 form-group mb-0 mt-3">
                                        <label
                                            style="font-weight: normal; color: #8997A4; font-style: italic; font-size: 0.9em;">*Alamat
                                            Tinggal/Domisili</label>

                                    </div>
                                </div>

                                {{-- Form Provinsi --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label>Provinsi</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <select name="provinsi"
                                            class="form-select @error('provinsi') is-invalid @enderror select2"
                                            data-placeholder="Pilih Provinsi">
                                            <option></option>
                                            <option value="Lampung"
                                                {{ old('provinsi') == 'Lampung' ? 'selected' : ($orangtua->provinsi == 'Lampung' ? 'selected' : '') }}>
                                                Lampung</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('provinsi')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Form Kabupaten --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label>Kabupaten</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <select name="kabupaten"
                                            class="form-select @error('kabupaten') is-invalid @enderror select2"
                                            data-placeholder="Pilih Kabupaten">
                                            <option></option>
                                            <option value="Lampung Timur"
                                                {{ old('kabupaten') == 'Lampung Timur' ? 'selected' : ($orangtua->kabupaten == 'Lampung Timur' ? 'selected' : '') }}>
                                                Lampung Timur
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('kabupaten')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Form Kecamatan --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label>Kecamatan</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <select name="kecamatan"
                                            class="form-select @error('kecamatan') is-invalid @enderror select2"
                                            data-placeholder="Pilih Kecamatan">
                                            <option></option>
                                            <option value="Batanghari"
                                                {{ old('kecamatan') == 'Batanghari' ? 'selected' : ($orangtua->kecamatan == 'Batanghari' ? 'selected' : '') }}>
                                                Batanghari
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('kecamatan')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Form Desa --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label>Desa</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <select name="desa"
                                            class="form-select @error('desa') is-invalid @enderror select2"
                                            data-placeholder="Pilih Desa">
                                            <option></option>
                                            <option value="Selorejo"
                                                {{ old('desa') == 'Selorejo' ? 'selected' : ($orangtua->desa == 'Selorejo' ? 'selected' : '') }}>
                                                Selorejo</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('desa')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Form Dusun --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="dusun">Dusun</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <select id="dusun" name="dusun"
                                            class="form-select @error('dusun') is-invalid @enderror select2"
                                            data-placeholder="Pilih Dusun">
                                            <option></option>
                                            @foreach ($dusuns as $dusun)
                                                <option value="{{ $dusun->id }}"
                                                    {{ old('dusun') == $dusun->id ? 'selected' : ($orangtua->dusun_id == $dusun->id ? 'selected' : '') }}>
                                                    {{ $dusun->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('dusun')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form RT --}}
                                <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="rt">RT</label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select id="rt" name="rt"
                                            class="form-select @error('rt') is-invalid @enderror select2"
                                            data-placeholder="Pilih RT"
                                            data-old-value="{{ old('rt') ?? $orangtua->rt_id }}">
                                            <option></option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('rt')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Form RW --}}
                                {{-- <div class="row d-flex">
                                    <div class="mt-3 col-md-4 text-md-end justify-content-end">
                                        <label for="rw">RW</label>
                                    </div>
                                    <div class="col-md-3 form-group mt-2">
                                        <select id="rw" name="rw"
                                            class="form-select @error('rw') is-invalid @enderror select2"
                                            data-placeholder="Pilih RW"
                                            data-old-value="{{ old('rw') ?? $orangtua->rw }}">
                                            <option></option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('rw')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}


                                {{-- Form Alamat Lengkap --}}
                                <div class="row d-flex mb-3 ">
                                    <div class="col-md-4 mt-2 text-md-end justify-content-end">
                                        <label>Alamat Lengkap</label>
                                    </div>
                                    <div class="col-md-5 form-group mt-2">
                                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="exampleFormControlTextarea1"
                                            rows="3">{{ old('alamat') ?? $orangtua->alamat }}</textarea>
                                        <div class="invalid-feedback">
                                            @error('alamat')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Simpan --}}
                                <div class="col-sm-12 d-flex justify-content-center">
                                    <button id="submitBtn" type="submit"
                                        class="btn btn-primary me-3 mb-1">Simpan</button>
                                    <a href="{{ route('orangtua.index') }}"
                                        class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Hapus Orangtua</h5>
                </div>
                <div class="card-body">
                    <p>Perhatian! Mengapus orangtua otomatis akan menghapus data balita.</p>
                    <div class="form-check">
                        <div class="checkbox">
                            <input type="checkbox" id="iaggree" class="form-check-input">
                            <label for="iaggree">Sentuh saya! Jika Anda setuju untuk menghapus
                                secara permanen</label>
                        </div>
                    </div>
                    <div class="form-group my-2 d-flex justify-content-end">
                        <form action="{{ route('orangtua.delete', ['id' => $orangtua->id]) }}" method="POST"
                            style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button id="btn-delete-account" type="submit"
                                class="btn icon btn-sm btn-danger mt-1 mb-1 me-1 swal-delete" disabled>
                                <i class="fa-regular fa-circle-x"></i> Hapus
                            </button>
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

    {{-- <script>
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
    </script> --}}

    {{-- Dusun, RT, RW DATA --}}
    <script>
        $(document).ready(function() {
            $('#dusun').change(function() {
                const dusunId = $(this).val();

                // Reset RT dan RW dropdown
                $('#rt').empty().append('<option></option>').prop('disabled', true);
                // $('#rw').empty().append('<option></option>').prop('disabled', true);

                if (dusunId) {
                    // Ambil RT berdasarkan dusun yang dipilih
                    $.ajax({
                        url: `/api/rt/${dusunId}`,
                        method: 'GET',
                        success: function(data) {
                            const oldRT = $('#rt').data('old-value');
                            $.each(data, function(index, rt) {
                                $('#rt').append(new Option(rt.rt, rt.id));
                            });
                            $('#rt').prop('disabled', false);
                            if (oldRT) {
                                $('#rt').val(oldRT).trigger('change'); // Pilih nilai lama
                            }
                        }
                    });

                    // Ambil RW berdasarkan dusun yang dipilih
                    // $.ajax({
                    //     url: `/api/rw/${dusunId}`,
                    //     method: 'GET',
                    //     success: function(data) {
                    //         const oldRW = $('#rw').data('old-value');
                    //         $.each(data, function(index, rw) {
                    //             $('#rw').append(new Option(rw,
                    //                 rw)); // Ambil RW dari response
                    //         });
                    //         $('#rw').prop('disabled', false);
                    //         if (oldRW) {
                    //             $('#rw').val(oldRW).trigger('change'); // Pilih nilai lama
                    //         }
                    //     }
                    // });
                }
            });

            // Trigger perubahan ketika halaman dimuat untuk mengisi nilai lama, jika ada
            if ($('#dusun').val()) {
                $('#dusun').trigger('change');
            }
        });
    </script>

    {{-- Ceklis Delete --}}
    <script>
        const checkbox = document.getElementById("iaggree")
        const buttonDeleteAccount = document.getElementById("btn-delete-account")
        checkbox.addEventListener("change", function() {
            const checked = checkbox.checked
            if (checked) {
                buttonDeleteAccount.removeAttribute("disabled")
            } else {
                buttonDeleteAccount.setAttribute("disabled", true)
            }
        })
    </script>

    {{-- SWAL DELETE --}}

    <script>
        $(document).ready(function() {
            // SweetAlert untuk konfirmasi penghapusan
            $(".swal-delete").click(function(event) {
                event.preventDefault();

                let form = $(this).closest("form");

                Swal.fire({
                    title: "Hapus Orangtua?",
                    text: "Data Orangtua akan dihapus secara permanen dan tidak dapat dikembalikan!",
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
@endsection
