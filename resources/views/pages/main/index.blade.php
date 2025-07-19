@extends('layout.main', ['title' => 'Dashboard'])

@section('cssLibraries')
    {{-- <style>
        .stat-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease;
            position: relative;
        }

        .stat-card-link:hover {
            color: inherit;
            transform: scale(1.02);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: absolute;
            right: 20px;
            top: 23px;
            z-index: 2;
        }

        .stat-card:hover .card-icon-wrapper {
            transform: rotate(45deg) scale(1.1) translateY(-5px);
        }

        .card-icon {
            font-size: 1.8rem;
            color: white;
            transition: all 0.3s ease;
        }

        .stat-card:hover .card-icon {
            transform: rotate(-45deg);
        }

        .card-content {
            padding: 25px;
            padding-right: 100px;
            position: relative;
            z-index: 1;
        }

        .stat-title {
            font-size: 1rem;
            color: #78828A;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .bg-gradient-danger {
            background: linear-gradient(45deg, #e74a3b, #be2617);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a, #13855c);
        }
    </style> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-range {
            background-color: #fff;
            cursor: pointer;
        }

        .stat-card {
            background-color: #fff;
            /* Warna putih */
            /* border: 1px solid #ddd; */
            /* Border tipis */
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .stat-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease;
            position: relative;
        }

        .stat-card-link:hover {
            color: inherit;
            transform: scale(1.02);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: absolute;
            right: 20px;
            top: 23px;
            z-index: 2;
        }

        .stat-card:hover .card-icon-wrapper {
            transform: rotate(45deg) scale(1.1) translateY(-5px);
        }

        .card-icon {
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .stat-card:hover .card-icon {
            transform: rotate(-45deg);
        }

        .card-content {
            padding: 25px;
            padding-right: 100px;
            position: relative;
            z-index: 1;
        }

        .stat-title {
            font-size: 1rem;
            color: #78828A;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .bg-gradient-danger {
            background: linear-gradient(45deg, #e74a3b, #be2617);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a, #13855c);
        }

        .bg-gradient-grey {
            background: linear-gradient(45deg, #868686, #686868);
        }

        #pengukuranChart {
            width: 100% !important;
            height: auto !important;
            /* Biar proporsional */
            max-height: 400px;
            /* Default untuk tampilan besar */
        }

        @media (max-width: 768px) {
            #pengukuranChart {
                height: 300px !important;

                /* Saat di layar kecil (mobile) */
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <span class="badge bg-info">
                    {{ $namaPosyandu ? 'Posyandu ' . $namaPosyandu->name : 'Semua Posyandu' }} <i
                        class="fa-solid fa-badge-check"></i></span>
            </li>
            {{-- <li class="breadcrumb-item active" aria-current="page">
                Data Pengukuran Balita
            </li> --}}
        </ol>
    </nav>
@endsection



@section('mainContent')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">

        {{-- DUMMY MAINTENANCE --}}
        {{-- <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <div class="text-center mt-5 mb-4">
                            <img src="{{ asset('assets/static/images/logo/sipegi-logo.svg') }}" alt="Sipegi Logo"
                                class="mb-4" style="max-width: 200px;">
                            <h2>Dashboard Sedang Dalam Proses Pengembangan</h2>
                            <p class="lead">Kami sedang mengutak-atiknya!</p>
                            <p>Klik tombol di bawah untuk memulai pengukuran</p>
                            <p class="mt-4">
                                <i class="fas fa-cog fa-spin" style="font-size: 3rem;"></i>
                            </p>
                            <a href="{{ route('balitaukur.index') }}" class="btn btn-primary mt-4">Mulai Pengukuran</a>
                        </div>



                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12 col-lg-9 mb-4">
                <div class="row g-4">


                    {{-- CARD ASLI --}}

                    {{-- <div class="col-xxl-4 col-md-6">
                        <div class="stat-card">
                            <a href="{{ route('gizi-bermasalah.stunting') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-danger">
                                    <i class="fa-solid fa-light-emergency-on card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Balita Stunting</div>
                                    <div class="stat-number">{{ $totalStunting }}</div>
                                </div>
                            </a>
                        </div>
                    </div> --}}

                    <div class="col-xxl-4 col-md-6">
                        <div class="stat-card">
                            <a href="{{ route('gizi-bermasalah.stunting') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-danger">
                                    <i class="fa-solid fa-light-emergency-on card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Balita Stunting</div>
                                    <div class="stat-number">{{ $totalStunting }}</div>
                                    {{-- <div class="stat-subtext text-muted mt-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-chart-line me-1 text-danger"></i><span
                                            style="font-style: italic;">Prevalensi = {{ $prevalensiStunting }}%</span>
                                    </div> --}}
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-6">
                        <div class="stat-card">
                            <a href="{{ route('gizi-bermasalah.bgm') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-danger">
                                    <i class="fa-solid fa-light-emergency-on card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Balita BGM</div>
                                    <div class="stat-number">{{ $totalBGM }}</div>
                                    {{-- <div class="stat-subtext text-muted mt-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-chart-line me-1 text-danger"></i><span
                                            style="font-style: italic;">Prevalensi = {{ $prevalensiBGM }}%</span>
                                    </div> --}}
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-6">
                        <div class="stat-card">
                            <a href="{{ route('gizi-bermasalah.duaT') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-danger">
                                    <i class="fa-solid fa-light-emergency-on card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Balita 2T</div>
                                    <div class="stat-number">{{ $total2T }}</div>
                                    {{-- <div class="stat-subtext text-muted mt-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-chart-line me-1 text-danger"></i><span
                                            style="font-style: italic;">Prevalensi = {{ $prevalensi2T }}%</span>
                                    </div> --}}
                                </div>
                            </a>
                        </div>
                    </div>



                    <div class="col-xxl-12 col-md-12">
                        <div class="stat-card">
                            <a href="{{ route('balitaukur.index') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-success">
                                    <i class="fa-solid fa-weight-scale card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Pengukuran Bulan Ini</div>
                                    <div class="stat-number">{{ $totalPengukuran }}</div>
                                </div>
                            </a>
                            <div class="p-3 pt-0">
                                <canvas id="pengukuranChart"></canvas>
                            </div>
                        </div>

                        <!-- Chart -->
                        {{-- <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Distribusi Pengukuran Bulan Ini</h5>
                                <canvas id="pengukuranChart" height="150"></canvas>
                            </div>
                        </div> --}}
                    </div>

                    {{-- Cek Prevalensi --}}
                    <div class="col-xxl-12 col-md-12">
                        <div class="card shadow-sm border-0 mb-1">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Cek Prevalensi Gizi Bermasalah</h5>

                                <form id="formPrevalensi" action="{{ route('cekprevalensi') }}" method="POST">
                                    @csrf
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <label for="jenisGizi" class="form-label">Jenis Gizi</label>
                                            <select class="form-select @error('jenisGizi') is-invalid @enderror"
                                                id="jenisGizi" name="jenisGizi">
                                                <option value="" disabled selected>Pilih Jenis Gizi</option>
                                                <option value="bgm">BB Kurang/Sangat Kurang (BB/U)</option>
                                                <option value="stunting">Stunting/Pendek (TB/U)</option>
                                                <option value="gizi_buruk">Gizi Kurang/Buruk (BB/TB)</option>
                                                <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                            </select>
                                            @error('jenisGizi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dateRange" class="form-label">Rentang Tanggal</label>
                                            <input type="text" id="dateRange" name="dateRange"
                                                class="form-control flatpickr-range @error('dateRange') is-invalid @enderror"
                                                placeholder="Pilih rentang tanggal" autocomplete="off">
                                            @error('dateRange')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-search me-1"></i> Cek
                                            </button>
                                            <button type="reset" class="btn btn-secondary w-100" id="resetPrevalensi">
                                                <i class="fas fa-undo me-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <hr class="my-4">

                                <div id="hasilPrevalensi" class="d-none">
                                    <h6 class="mb-3">Hasil Cek Prevalensi</h6>
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="stat-number" id="jumlahKasus">0</div>
                                            <div class="stat-title">Jumlah Kasus</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="stat-number" id="jumlahPengukuran">0</div>
                                            <div class="stat-title">Jumlah Pengukuran</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="stat-number text-primary" id="prevalensiPersen">0%</div>
                                            <div class="stat-title">Prevalensi</div>
                                        </div>
                                    </div>
                                </div>

                                <div id="loadingPrevalensi" class="text-center d-none mt-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Memuat...</span>
                                    </div>
                                    <p class="mt-2 mb-0">Menghitung prevalensi...</p>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- <div class="col-xxl-4 col-md-6">
                <div class="stat-card">
                    <a href="{{ route('balita.index') }}" class="stat-card-link text-decoration-none">
                        <div class="card-icon-wrapper bg-gradient-primary">
                            <i class="fas fa-children card-icon"></i>
                        </div>
                        <div class="card-content">
                            <div class="stat-title">Total Balita</div>
                            <div class="stat-number">{{ $totalBalitas }}</div>
                        </div>
                    </a>
                </div>
            </div> --}}







                </div>
            </div>


            <div class="col-12 col-lg-3 mb-4">
                <div class="row g-4">
                    <div class="col-xxl-12 col-md-12">
                        <div class="stat-card">
                            <a href="{{ route('balita.index') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-primary">
                                    <i class="fas fa-children card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Total Balita</div>
                                    <div class="stat-number">{{ $totalBalitas }}</div>
                                </div>
                            </a>
                            <!-- Tambahkan Chart -->
                            <div style="padding: 15px;">
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="stat-card">
                            <a href="#" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-grey">
                                    <i class="fas fa-children card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Total Balita Nonaktif</div>
                                    <div class="stat-number">{{ $totalBalitaNonaktif }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="stat-card">
                            <a href="{{ route('orangtua.index') }}" class="stat-card-link text-decoration-none">
                                <div class="card-icon-wrapper bg-gradient-warning">
                                    <i class="fa-solid fa-person-breastfeeding card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <div class="stat-title">Total Orangtua</div>
                                    <div class="stat-number">{{ $totalOrangtuas }}</div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        {{-- Cek Prevalensi --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#formPrevalensi').on('submit', function(e) {
                    e.preventDefault();

                    // Tampilkan loading, sembunyikan hasil
                    $('#loadingPrevalensi').removeClass('d-none');
                    $('#hasilPrevalensi').addClass('d-none');

                    // Kirim data
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(), // ambil semua input form
                        success: function(response) {
                            $('#loadingPrevalensi').addClass('d-none');

                            // Tampilkan hasil
                            $('#jumlahKasus').text(response.jumlah_kasus);
                            $('#jumlahPengukuran').text(response.jumlah_pengukuran);
                            $('#prevalensiPersen').text(response.prevalensi + '%');

                            $('#hasilPrevalensi').removeClass('d-none');
                        },
                        error: function(xhr) {
                            $('#loadingPrevalensi').addClass('d-none');
                            alert('Terjadi kesalahan. Silakan cek form dan coba lagi.');
                        }
                    });
                });

                $('#resetPrevalensi').on('click', function() {
                    $('#hasilPrevalensi').addClass('d-none');
                });
            });
        </script>






        <br>
        <br>

    </div>
@endsection

@section('jsLibraries')
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> <!-- Tambahkan Plugin -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("genderChart").getContext("2d");

            var genderChart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: ["Laki-laki", "Perempuan"],
                    datasets: [{
                        data: [{{ $totalLaki }},
                            {{ $totalPerempuan }}
                        ], // Ambil dari controller
                        backgroundColor: ["#3DA5FF", "#FE74BB"], // Warna untuk L dan P
                        // hoverBackgroundColor: ["#2C8EC0", "#d64f95"]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                        },
                        datalabels: { // Tambahkan Data Labels
                            color: "#fff",
                            anchor: "center",
                            align: "center",
                            font: {
                                weight: "bold",
                                size: 18
                            },
                            formatter: (value, ctx) => {
                                return value; // Menampilkan jumlah langsung
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Aktifkan plugin
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("pengukuranChart").getContext("2d");

            var chartData = {!! json_encode($chartData) !!};

            var labels = chartData.map(item => item.posyandu);
            var dataLaki = chartData.map(item => item.laki);
            var dataPerempuan = chartData.map(item => item.perempuan);

            var pengukuranChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                            label: "Laki-laki",
                            data: dataLaki,
                            backgroundColor: "#3DA5FF"
                        },
                        {
                            label: "Perempuan",
                            data: dataPerempuan,
                            backgroundColor: "#FE74BB"
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: "Posyandu"
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: "Jumlah Balita"
                            },
                            beginAtZero: true,
                            max: 20 // Batas maksimal Y-axis agar tidak terlalu tinggi
                        }
                    },
                    plugins: {
                        datalabels: {
                            anchor: "end", // Posisi angka di atas batang
                            align: "top",
                            color: "#2C3F51",
                            font: {
                                weight: "bold",
                                size: 12
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Aktifkan plugin
            });
        });
    </script>
    <script>
        // CONFIG FLATPICKR
        flatpickr(".flatpickr-range", {

            "locale": "id",
            mode: "range",
            altInput: true,
            altInputClass: 'form-control',
            altFormat: "j F Y",
            minDate: "2024-09-01",
            maxDate: "today",
            disableMobile: "true",



        });
    </script>
@endsection
