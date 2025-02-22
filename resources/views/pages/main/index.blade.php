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
    <style>
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


                    <div class="col-xxl-4 col-md-6">
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
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xxl-8 col-md-6">
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
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
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
                    {{-- <div class="col-xxl-12 col-md-12">
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
                    </div> --}}
                </div>
            </div>
        </div>



        <br>
        <br>

    </div>
@endsection

@section('jsLibraries')
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

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
    </script>
@endsection
