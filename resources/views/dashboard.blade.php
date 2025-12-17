@extends('layouts.app', [
    'activePage' => 'dashboard',
])


@push('plugin-styles')
<style>
    .dashboard-card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
    }

    .card-total {
        border-left-color: #6c757d;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .card-baik {
        border-left-color: #28a745;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .card-rusak {
        border-left-color: #dc3545;
        background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        color: white;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        font-size: 28px;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .badge-info {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid">
    {{-- Header dengan Gradien --}}
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold mb-2">
                    <i class="fas fa-chart-line me-2"></i>Dashboard Manajemen Barang
                </h3>
                <p class="mb-0 opacity-90">
                    <i class="fas fa-info-circle me-1"></i>
                    Pantau data barang dan kondisi secara real-time
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge-info">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ date('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Kartu Statistik dengan Icon --}}
    <div class="row g-3 mb-4">
        {{-- Total Barang --}}
        <div class="col-md-4">
            <div class="card dashboard-card card-total shadow-sm border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-2 opacity-90 fw-semibold">
                            <i class="fas fa-boxes me-2"></i>Total Barang
                        </p>
                        <h2 class="fw-bold mb-0">{{ number_format($totalBarang) }}</h2>
                        <small class="opacity-75">Semua kategori</small>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barang Baik --}}
        <div class="col-md-4">
            <div class="card dashboard-card card-baik shadow-sm border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-2 opacity-90 fw-semibold">
                            <i class="fas fa-check-circle me-2"></i>Kondisi Berfungsi
                        </p>
                        <h2 class="fw-bold mb-0">{{ number_format($barangBerfungsi) }}</h2>
                        <small class="opacity-75">
                            {{ $totalBarang > 0 ? round(($barangBerfungsi/$totalBarang)*100, 1) : 0 }}% dari total
                        </small>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barang Rusak --}}
        <div class="col-md-4">
            <div class="card dashboard-card card-rusak shadow-sm border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-2 opacity-90 fw-semibold">
                            <i class="fas fa-exclamation-triangle me-2"></i>Kondisi Rusak
                        </p>
                        <h2 class="fw-bold mb-0">{{ number_format($barangRusak) }}</h2>
                        <small class="opacity-75">
                            {{ $totalBarang > 0 ? round(($barangRusak/$totalBarang)*100, 1) : 0 }}% dari total
                        </small>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Bar Perbandingan --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Perbandingan Kondisi Barang
                </h6>
                <div class="progress" style="height: 30px; border-radius: 10px;">
                    <div class="progress-bar bg-success" role="progressbar"
                         style="width: {{ $totalBarang > 0 ? ($barangBerfungsi/$totalBarang)*100 : 0 }}%"
                         aria-valuenow="{{ $barangBerfungsi }}"
                         aria-valuemin="0"
                         aria-valuemax="{{ $totalBarang }}">
                        <strong>Berfungsi: {{ $barangBerfungsi }}</strong>
                    </div>
                    <div class="progress-bar bg-danger" role="progressbar"
                         style="width: {{ $totalBarang > 0 ? ($barangRusak/$totalBarang)*100 : 0 }}%"
                         aria-valuenow="{{ $barangRusak }}"
                         aria-valuemin="0"
                         aria-valuemax="{{ $totalBarang }}">
                        <strong>Rusak: {{ $barangRusak }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik dengan Header Lebih Baik --}}
    <div class="chart-container">
        <div class="chart-header">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>
                    Distribusi Barang per Tahun
                </h5>
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Grafik menampilkan jumlah barang berdasarkan tahun pengadaan
                </small>
            </div>
            <div>
                <span class="badge bg-primary">
                    <i class="fas fa-database me-1"></i>
                    {{ count($grafikTahun) }} Tahun
                </span>
            </div>
        </div>

        <div style="position: relative; height: 400px;">
            <canvas id="grafikBarang"></canvas>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log('📊 Initializing Dashboard Chart...');

    const ctx = document.getElementById('grafikBarang');

    if (!ctx) {
        console.error('❌ Canvas element not found');
        return;
    }

    const dataTahun = @json($grafikTahun->pluck('tahun'));
    const dataTotal = @json($grafikTahun->pluck('total'));

    console.log('📅 Data Tahun:', dataTahun);
    console.log('📈 Data Total:', dataTotal);

    // Cek apakah ada data
    if (dataTahun.length === 0) {
        ctx.parentElement.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data untuk ditampilkan</p>
            </div>
        `;
        return;
    }

    // Cek apakah Chart.js sudah dimuat
    if (typeof Chart === 'undefined') {
        console.error('❌ Chart.js is not loaded');
        ctx.parentElement.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Chart.js gagal dimuat. Silakan refresh halaman.
            </div>
        `;
        return;
    }

    try {
        // Gradient untuk bar chart
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
        gradient.addColorStop(1, 'rgba(118, 75, 162, 0.8)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dataTahun,
                datasets: [{
                    label: 'Jumlah Barang',
                    data: dataTotal,
                    backgroundColor: gradient,
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 13,
                                weight: '600'
                            },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return ' Total: ' + context.parsed.y + ' barang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        console.log('✅ Chart created successfully');
    } catch (error) {
        console.error('❌ Error creating chart:', error);
        ctx.parentElement.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Gagal membuat grafik: ${error.message}
            </div>
        `;
    }
});
</script>
@endpush
