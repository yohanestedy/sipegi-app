@extends('layout.main', ['title' => 'Laporan'])

@section('cssLibraries')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.css" rel="stylesheet">
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('laporan.index') }}">Laporan</a>
            </li>
        </ol>
    </nav>
@endsection

@section('mainContent')
    <div class="page-heading mb-4">
        <h3>Laporan</h3>
        <p class="text-muted">Halaman laporan untuk mengekspor data.</p>
    </div>

    <div class="page-content">
        {{-- EXPORT PENGUKURAN --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="card-title">Ekspor Daftar Pengukuran Balita</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.export-pengukuranbalita') }}" class="form form-horizontal">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <select name="posyandu_id" class="form-select @error('posyandu_id') is-invalid @enderror"
                                data-placeholder="Pilih Posyandu">
                                <option selected disabled value="">--Pilih Posyandu--</option>
                                @if (in_array(Auth::user()->role, ['super_admin', 'admin', 'kader_poskesdes']))
                                    <option value="0" {{ old('posyandu_id') == '0' ? 'selected' : '' }}>Semua Posyandu
                                    </option>
                                @endif
                                @foreach ($posyandus as $posyandu)
                                    <option value="{{ $posyandu->id }}"
                                        {{ old('posyandu_id') == $posyandu->id ? 'selected' : '' }}>
                                        {{ $posyandu->name }} / {{ $posyandu->dusun->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('posyandu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <input id="periode" name="periode" type="text"
                                class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode') }}"
                                placeholder="--Periode Bulan--" />
                            @error('periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fa-solid fa-arrow-down-to-line"></i> Download
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- EXPORT GIZI BERMASALAH --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="card-title">Ekspor Balita Gizi Bermasalah</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.export-balitagizibermasalah') }}"
                    class="form form-horizontal">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <select name="statusMasalah" class="form-select @error('statusMasalah') is-invalid @enderror">
                                <option selected disabled value="">--Pilih Status Gizi Bermasalah--</option>
                                <option value="STUNTING">STUNTING</option>
                                <option value="BGM">BGM</option>
                                <option value="2T">2T</option>
                            </select>
                            @error('statusMasalah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <input id="periode" name="periodeMasalah" type="text"
                                class="form-control @error('periodeMasalah') is-invalid @enderror"
                                value="{{ old('periodeMasalah') }}" placeholder="--Periode Bulan--" />
                            @error('periodeMasalah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-5 mb-3">

                            <div class="form-check mt-2">
                                <div class="checkbox">
                                    <input type="checkbox" id="iaggree" name="include_previous" value="1"
                                        class="form-check-input">
                                    <label for="iaggree">Sertakan balita yang belum diukur pada bulan terpilih, tapi
                                        terakhir tercatat gizi bermasalah.</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fa-solid fa-arrow-down-to-line"></i> Download
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- EXPORT BIODATA BALITA --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="card-title">Ekspor Biodata Balita</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.export-biodatabalita') }}" class="form form-horizontal">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <select name="posyandu_id_satu"
                                class="form-select @error('posyandu_id_satu') is-invalid @enderror"
                                data-placeholder="Pilih Posyandu">
                                <option selected disabled value="">--Pilih Posyandu--</option>
                                @if (in_array(Auth::user()->role, ['super_admin', 'admin', 'kader_poskesdes']))
                                    <option value="0" {{ old('posyandu_id_satu') == '0' ? 'selected' : '' }}>Semua
                                        Posyandu</option>
                                @endif
                                @foreach ($posyandus as $posyandu)
                                    <option value="{{ $posyandu->id }}"
                                        {{ old('posyandu_id_satu') == $posyandu->id ? 'selected' : '' }}>
                                        {{ $posyandu->name }} / {{ $posyandu->dusun->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('posyandu_id_satu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fa-solid fa-arrow-down-to-line"></i> Download
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('jsLibraries')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr("#periode", {
            "locale": "id",
            altInput: true,
            disableMobile: "true",
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "m.y",
                    altFormat: "F Y",
                }),
            ],
        });

        $('.select2').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: $(this).data('placeholder'),
        });
    </script>
@endsection
