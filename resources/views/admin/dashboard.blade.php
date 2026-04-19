@extends('layouts.admin')

@section('title', 'Dashboard Admin - SPK MOORA')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan</a>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Total Guru Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Guru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Guru::count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kriteria Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kriteria Penilaian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Kriteria::count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Roles Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\User::where('role', 'admin')->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Top 5 Guru Terbaik (Periode: {{ $latestPeriod ? date('F Y', strtotime($latestPeriod.'-01')) : 'Belum Ada' }})</h6>
            </div>
            <div class="card-body">
                @if(empty($top5))
                    <div class="text-center py-4 text-muted">Belum ada data evaluasi untuk divisualisasikan.</div>
                @else
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Area Info -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Selamat Datang Kepsek!</h6>
            </div>
            <div class="card-body">
                Sistem Pendukung Keputusan Penilaian Kinerja Guru Metode MOORA sudah siap digunakan. Silakan gunakan menu di sebelah kiri untuk mengelola Data Guru dan Kriteria.
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
<script>
@if(!empty($top5))
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($top5, 'guru')) !!},
            datasets: [{
                label: "Nilai MOORA",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: {!! json_encode(array_column($top5, 'nilai_yi')) !!},
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
                xAxes: [{
                    time: { unit: 'month' },
                    gridLines: { display: false, drawBorder: false },
                    ticks: { maxTicksLimit: 6 },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: { min: 0, padding: 10 },
                    gridLines: { color: "rgb(234, 236, 244)", zeroLineColor: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2], zeroLineBorderDash: [2] }
                }],
            },
            legend: { display: false },
            tooltips: {
                titleMarginBottom: 10, titleFontColor: '#6e707e', titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796",
                borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15,
                displayColors: false, caretPadding: 10,
            },
        }
    });
@endif
</script>
@endpush
